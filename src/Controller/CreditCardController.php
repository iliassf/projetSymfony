<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CreditCardController extends AbstractController
{
    #[Route('/credit/card', name: 'app_credit_card')]
    public function index(AuthorizationCheckerInterface $authorizationChecker, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$authorizationChecker->isGranted('ROLE_USER') || $authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        $user = $this->getUser();
        $wallet = $user->getWallet();
        $form = $this->createForm(WalletType::class, $wallet);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($wallet->getCreditCards() as $creditCard){
                $creditCard->setUser($user);
            }
            $entityManager->persist($wallet);
            $entityManager->flush();
        }

        return $this->render('credit_card/index.html.twig', [
            'form' => $form->createView(),
        ]);
    
    }
}
