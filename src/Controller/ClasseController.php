<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ClassType;
use App\Entity\Classe;
use App\Repository\ClasseRepository;
use Knp\Component\Pager\PaginatorInterface;

class ClasseController extends AbstractController
{
    public function index(ClasseRepository $classeRepository , Request $request , EntityManagerInterface $em , PaginatorInterface $paginator): Response
    {

        $sql = "SELECT c FROM App\Entity\Classe c";
        $query = $em->createQuery($sql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('classe/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        
        $classe = new Classe();

        $form  = $this->createForm(ClassType::class,$classe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('app_classe_index');
        }

        return $this->render('classe/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Classe $classe): Response
    {
        $form  = $this->createForm(ClassType::class,$classe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('app_classe_index');
        }

        return $this->render('classe/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $entityManager , Classe $classe){

        $entityManager->remove($classe);
        $entityManager->flush();

        return $this->redirectToRoute('app_classe_index');
    }
}
