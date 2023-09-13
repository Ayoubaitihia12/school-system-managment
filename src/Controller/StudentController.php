<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StudentType;
use App\Entity\Student;

class StudentController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('student/index.html.twig');
    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $student = new Student();

        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('app_students_index');
        }

        return $this->render('student/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function view(): Response
    {
        return $this->render('student/view.html.twig');
    }
}
