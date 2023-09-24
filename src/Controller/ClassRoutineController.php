<?php

namespace App\Controller;

use App\Entity\ClassRoutine;
use App\Form\ClassRoutineType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassRoutineController extends AbstractController
{
    public function index(EntityManagerInterface $em , Request $request , PaginatorInterface $paginator): Response
    {
        $dql   = "SELECT c FROM App\Entity\ClassRoutine c";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('class_routine/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $classRoutine = new ClassRoutine();

        $form = $this->createForm(ClassRoutineType::class,$classRoutine);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($classRoutine);
            $em->flush();

            return $this->redirectToRoute('app_classRoutine_index');
        }

        return $this->render('class_routine/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , ClassRoutine $classRoutine): Response
    {

        $form = $this->createForm(ClassRoutineType::class,$classRoutine);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($classRoutine);
            $em->flush();

            return $this->redirectToRoute('app_classRoutine_index');
        }

        return $this->render('class_routine/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , ClassRoutine $classRoutine)
    {
        $em->remove($classRoutine);
        $em->flush();

        return $this->redirectToRoute('app_classRoutine_index');
    }
}
