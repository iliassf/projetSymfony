<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart.show')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $sessionCart = $session->get('panier',[]);
        $cart = [];
        foreach($sessionCart as $id => $quantity ){
            $cart[] = ["product"=>$productRepository->find($id),"quantity"=>$quantity];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }
    
    #[Route('/addToCart/{id}', name: 'cart.add')]
    public function addToCart($id, SessionInterface $session): Response
    {
        $nb = isset($_POST['nb'])?$_POST['nb']:1;

        $panier = $session->get('panier',[]);

        if(empty($panier[$id])){
            $panier[$id] = $nb;
        }else{
            $panier[$id] = $panier[$id] + $nb;
        }

        $session->set('panier', $panier);

        return new Response();
    }
}
