<?php

namespace App\Controller;

use App\Entity\Wallet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CreditCardType;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreditCardController extends AbstractController
{
    #[Route('/credit/card', name: 'app_credit_card')]
    public function index(Request $request, EntityManagerInterface $entityManager, WalletRepository $walletRepository): Response
    {
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
            
            $this->addFlash('success', 'Les modifications ont été enregistrées');
        }

        return $this->render('credit_card/index.html.twig', [
            'form' => $form->createView(),
        ]);
    
    }
}
