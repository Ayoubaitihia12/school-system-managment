<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Exam;
use App\Form\ExamType;

class ExamController extends AbstractController
{

    public function index(EntityManagerInterface $em , Request $request , PaginatorInterface $paginator): Response
    {

        $dql   = "SELECT e FROM App\Entity\Exam e";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('exam/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(EntityManagerInterface $em , Request $request):Response
    {
        $exam = new Exam();

        $form = $this->createForm(ExamType::class,$exam);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('app_exam_index');
        }
        return $this->render('exam/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(EntityManagerInterface $em , Request $request , Exam $exam):Response
    {

        $form = $this->createForm(ExamType::class,$exam);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('app_exam_index');
        }
        return $this->render('exam/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , Exam $exam)
    {
        $em->remove($exam);
        $em->flush();

        return $this->redirectToRoute('app_exam_index');
    }
}
