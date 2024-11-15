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
    
    #[Route('/addToCart', name: 'cart.add')]
    public function addToCart(SessionInterface $session): Response
    {
        $id = isset($_POST['id'])?$_POST['id']:null;
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

    #[Route('/deleteFromCart', name: 'cart.delete')]
    public function deleteFromCart(SessionInterface $session): Response
    {
        $id = isset($_POST['id'])?$_POST['id']:null;

        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return new Response();
    }

    #[Route('/modifyElementFromCart', name: 'cart.modify')]
    public function modifyToCart(SessionInterface $session): Response
    {
        $id = isset($_POST['id'])?$_POST['id']:null;
        $nb = isset($_POST['nb'])?$_POST['nb']:1;

        $panier = $session->get('panier',[]);

        if(empty($panier[$id])){
            $panier[$id] = $nb;
        }

        $session->set('panier', $panier);

        return new Response();
    }
}
