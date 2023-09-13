<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Subject;
use App\Form\SubjectType;
use Knp\Component\Pager\PaginatorInterface;

class SubjectController extends AbstractController
{
    public function index(Request $request , EntityManagerInterface $em , PaginatorInterface $paginator): Response
    {
        $sql = "SELECT s FROM App\Entity\Subject s";
        $query = $em->createQuery($sql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('subject/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(Request $request , EntityManagerInterface $entityManager): Response
    {
        $subject = new Subject();

        $form = $this->createForm(SubjectType::class,$subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('app_subject_index');
        }

        return $this->render('subject/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $entityManager , Subject $subject): Response
    {

        $form = $this->createForm(SubjectType::class,$subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('app_subject_index');
        }

        return $this->render('subject/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $entityManager , Subject $subject){

        $entityManager->remove($subject);
        $entityManager->flush();

        return $this->redirectToRoute('app_subject_index');
    }
}
