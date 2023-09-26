<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Subject;
use App\Form\SubjectType;
use Knp\Component\Pager\PaginatorInterface;
use App\Model\SubjectSearch;
use App\Form\SubjectSearchType;

class SubjectController extends AbstractController
{
    public function index(Request $request , EntityManagerInterface $em , PaginatorInterface $paginator): Response
    {

        $subjectSearch = new SubjectSearch();

        $form = $this->createForm(SubjectSearchType::class,$subjectSearch);
        $form->handleRequest($request);

        $queryBuilder = $em->getRepository(Subject::class)->createQueryBuilder('s');

        if($form->isSubmitted() && $form->isValid()){
            
            if(!empty($subjectSearch->name)){
                $queryBuilder->Where('s.Name LIKE :name')
                ->setParameter('name', '%'.$subjectSearch->name.'%');
            }

            if(!empty($subjectSearch->type)){
                $queryBuilder->andWhere('s.Type = :type')
                ->setParameter('type', $subjectSearch->type);
            }

            if(!empty($subjectSearch->class)){
                $queryBuilder->andWhere('s.Class = :class')
                ->setParameter('class', $subjectSearch->class);
            }
        }

        $query = $queryBuilder->getQuery();     

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('subject/index.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView()
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
