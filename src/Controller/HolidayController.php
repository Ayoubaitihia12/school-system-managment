<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Holiday;
use App\Form\HolidayType;

class HolidayController extends AbstractController
{
    public function index(EntityManagerInterface $em , Request $request , PaginatorInterface $paginator): Response
    {

        $dql   = "SELECT h FROM App\Entity\Holiday h";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('holiday/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    public function add(EntityManagerInterface $em , Request $request):Response
    {
        $holiday = new Holiday();

        $form = $this->createForm(HolidayType::class,$holiday);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($holiday);
            $em->flush();

            return $this->redirectToRoute('app_holiday_index');
        }
        return $this->render('holiday/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(EntityManagerInterface $em , Request $request , Holiday $holiday):Response
    {

        $form = $this->createForm(HolidayType::class,$holiday);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            $em->persist($holiday);
            $em->flush();

            return $this->redirectToRoute('app_holiday_index');
        }
        return $this->render('holiday/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em ,  Holiday $holiday)
    {
        $em->remove($holiday);
        $em->flush();

        return $this->redirectToRoute('app_holiday_index');
    }
}
