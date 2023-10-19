<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;

class TestController extends AbstractController
{
    public function __construct(
        private LocaleSwitcher $localeSwitcher,
    ) {
    }
    public function index(Request $request , TranslatorInterface $translator , LocaleSwitcher $localeSwitcher): Response
    {
        
        // $this->localeSwitcher->setLocale('fr');

        // dd($greeting);
    
        return $this->render('test/index.html.twig');
    }

    public function changeLocale(Request $request, $_locale): Response
    {
        $this->localeSwitcher->setLocale($_locale);

        return $this->redirect($request->headers->get('referer'));
    }
}
