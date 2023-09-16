<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Parents;
use App\Form\ParentUpdateType;
use App\Form\ParentType;

class ParentController extends AbstractController
{
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $dql   = "SELECT p FROM App\Entity\Parents p";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('parent/index.html.twig',[
            'pagination' => $pagination
        ]);

    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $parent = new Parents();

        $form = $this->createForm(ParentType::class,$parent);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($parent);
            $em->flush();

            return $this->redirectToRoute('app_parent_index');
        }

        return $this->render('parent/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Parents $parent): Response
    {

        $updateForm = $this->createForm(ParentUpdateType::class,$parent);
        $updateForm->handleRequest($request);

        if($updateForm->isSubmitted() && $updateForm->isValid()){

            $em->persist($parent);
            $em->flush();

            return $this->redirectToRoute('app_parent_index');
        }

        return $this->render('parent/update.html.twig',[
            'form' => $updateForm->createView()
        ]);
    }
    
    public function delete(EntityManagerInterface $em , Parents $parent)
    {
        $em->remove($parent);
        $em->flush();

        return $this->redirectToRoute('app_parent_index');
    }
}
