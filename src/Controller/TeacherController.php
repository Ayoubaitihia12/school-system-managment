<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Form\TeacherUpdateType;
use Knp\Component\Pager\PaginatorInterface;

class TeacherController extends AbstractController
{

    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $dql   = "SELECT t FROM App\Entity\Teacher t";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('teacher/index.html.twig',[
            'pagination' => $pagination
        ]);

    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $teacher = new Teacher();

        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $today = new \DateTime();
            $teacher->setJoiningDate($today);

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('app_teacher_index');
        }

        return $this->render('teacher/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Teacher $teacher): Response
    {

        $update_form = $this->createForm(TeacherUpdateType::class,$teacher);
        $update_form->handleRequest($request);

        if($update_form->isSubmitted() && $update_form->isValid()){
            
            $today = new \DateTime();
            $teacher->setJoiningDate($today);

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('app_teacher_index');
        }

        return $this->render('teacher/update.html.twig',[
            'form' => $update_form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , Teacher $teacher)
    {
        $em->remove($teacher);
        $em->flush();

        return $this->redirectToRoute('app_teacher_index');
    }
}
