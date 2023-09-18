<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class TestController extends AbstractController
{
    public function index(TranslatorInterface $translator , Request $request): Response
    {
       
        $request->setLocale('fr');

        dd($request->getLocale());

        return $this->render('test/index.html.twig');
    }
}
