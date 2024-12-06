<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends AbstractController
{
    #[Route("/change-locale/{_locale}", name: 'change_locale')]
    public function changeLocale(Request $request, string $_locale): RedirectResponse
    {
        $request->getSession()->set('_locale', $_locale);

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer ?: '/');
    }
}
