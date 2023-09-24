<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Polyfill\Intl\Icu\Locale;

class TestController extends AbstractController
{
    public function index(Request $request): Response
    {
        Locale::setDefault('en_US');
        
        $language = $request->getLocale();

        if ($language === 'en') {
            $request->setLocale('fr');
        } elseif ($language === 'fr') {
            $request->setLocale('en');
        }

        // dd($language);
    
        return $this->render('test/index.html.twig');
    }
}
