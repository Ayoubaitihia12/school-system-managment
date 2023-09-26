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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Model\ParentSearch;
use App\Form\ParentSearchType;

class ParentController extends AbstractController
{
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $parentSearch = new ParentSearch();

        $form = $this->createForm(ParentSearchType::class,$parentSearch);
        $form->handleRequest($request);

        $queryBuilder = $em->getRepository(Parents::class)->createQueryBuilder('t');

        if($form->isSubmitted() && $form->isValid()){

            if(!empty($parentSearch->name)){
                $queryBuilder->Where('t.firstName LIKE :name')
                ->setParameter('name', '%'.$parentSearch->name.'%');
            }

            if(!empty($parentSearch->student)){
                $queryBuilder->innerJoin('t.students','s')
                ->andwhere('t.firstName = :name')
                ->andWhere('s.FirstName LIKE :student')
                ->setParameter('name',$parentSearch->name)
                ->setParameter('student',$parentSearch->student);
            }
        }

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('parent/index.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);

    }

    public function add(Request $request , EntityManagerInterface $em , UserPasswordHasherInterface $passwordHasher): Response
    {
        $parent = new Parents();

        $form = $this->createForm(ParentType::class,$parent);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $password = $parent->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
                $parent,
                $password
            );

            $parent->setPassword($hashedPassword);

            $parent->setRoles(['ROLE_PARENT']);

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
