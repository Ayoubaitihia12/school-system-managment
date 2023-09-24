<?php

namespace App\Controller;

use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{

    public function listEvents(EventRepository $eventRepository): JsonResponse
    {
        $events = $eventRepository->findAll();

        $formattedEvents = [];

        foreach($events as $event){
            $formattedEvents[] = [
                'title' => $event->getName(),
                'start' =>  $event->getDay()->format('Y-m-d') .' '. $event->getStart()->format('H:i:s'),
                'end' => $event->getDay()->format('Y-m-d') .' '. $event->getEnd()->format('H:i:s'),
            ];
        }

        return new JsonResponse($formattedEvents);
    }

    public function index(): Response
    {

        return $this->render('event/index.html.twig');
    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event_index');
        }

        return $this->render('event/add.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
