<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\StudentType;
use App\Entity\Student;
use App\Form\StudentTypeUpdateType;

class StudentController extends AbstractController
{
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $dql   = "SELECT s FROM App\Entity\Student s";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('student/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(Request $request , EntityManagerInterface $em , UserPasswordHasherInterface $passwordHasher): Response
    {
        $student = new Student();

        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $password = $student->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
                $student,
                $password
            );

            $student->setPassword($hashedPassword);
            
            $today = new \DateTime();
            $student->setAdmissionDate($today);

            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('app_students_index');
        }

        return $this->render('student/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Student $student): Response
    {
        $Updateform = $this->createForm(StudentTypeUpdateType::class,$student);
        $Updateform->handleRequest($request);

        if($Updateform->isSubmitted() && $Updateform->isValid()){
            
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('app_students_index');
        }

        return $this->render('student/update.html.twig',[
            'form' => $Updateform->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , Student $student)
    {
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('app_students_index');
    }

    public function view(): Response
    {
        return $this->render('student/view.html.twig');
    }
}
