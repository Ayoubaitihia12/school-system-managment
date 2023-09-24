<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    public function index(EntityManagerInterface $em): Response
    {
        
        $nbrStudent = $em->getRepository(Student::class)->count([]);
        $nbrTeacher = $em->getRepository(Teacher::class)->count([]);
        $nbrParent = $em->getRepository(Teacher::class)->count([]);
        $nbrClass = $em->getRepository(Classe::class)->count([]);
        $nbrSubject = $em->getRepository(Subject::class)->count([]);

        return $this->render('dashboard/index.html.twig',[
            'nbrStudent' => $nbrStudent,
            'nbrTeacher' => $nbrTeacher,
            'nbrParent' => $nbrParent,
            'nbrClass' => $nbrClass,
            'nbrSubject' => $nbrSubject
        ]);
    }
}
