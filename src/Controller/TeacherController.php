<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Teacher;
use App\Form\TeacherType;

class TeacherController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/index.html.twig');
    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $teacher = new Teacher();

        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('app_teacher_index');
        }

        return $this->render('teacher/add.html.twig');
    }
}
