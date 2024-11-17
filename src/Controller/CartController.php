<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart.show')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $sessionCart = $session->get('panier',[]);
        $cart = [];
        $sousTotal = 0;

        foreach($sessionCart as $id => $quantity ){
            $product = $productRepository->find($id);
            $cart[] = ["product"=>$product,"quantity"=>$quantity];
            $sousTotal += $product->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart, 'sousTotal' => $sousTotal
        ]);
    }
    
    #[Route('/addToCart', name: 'cart.add')]
    public function addToCart(SessionInterface $session): JsonResponse
    {
        $id = isset($_POST['id'])?$_POST['id']:null;
        $nb = isset($_POST['nb'])?$_POST['nb']:1;

        $panier = $session->get('panier',[]);
        $cartSize = 0;

        if(empty($panier[$id])){
            $panier[$id] = $nb;
        }else{
            $panier[$id] = $panier[$id] + $nb;
        }

        foreach($panier as $id => $quantity ){
            $cartSize +=  $quantity;
        }

        $session->set('panier', $panier);

        return new JsonResponse(["cartSize"=>$cartSize]);
    }

    #[Route('/deleteFromCart', name: 'cart.delete')]
    public function deleteFromCart(SessionInterface $session, ProductRepository $productRepository): JsonResponse
    {
        $id = isset($_POST['id'])?$_POST['id']:null;

        $panier = $session->get('panier',[]);
        $sousTotal = 0;
        $cartSize = 0;

        if(!empty($panier[$id])){
            unset($panier[$id]);
            foreach($panier as $id => $quantity ){
                $sousTotal += $productRepository->find($id)->getPrice() * $quantity;
                $cartSize +=  $quantity;
            }
        }

        $session->set('panier', $panier);

        return new JsonResponse(["cart"=>$panier,"sousTotal"=>$sousTotal,"cartSize"=>$cartSize]);
    }

    #[Route('/modifyElementFromCart', name: 'cart.modify')]
    public function modifyToCart(SessionInterface $session, ProductRepository $productRepository): JsonResponse
    {
        $id = isset($_POST['id'])?$_POST['id']:null;
        $nb = isset($_POST['nb'])?$_POST['nb']:1;

        $panier = $session->get('panier',[]);
        $sousProduct = 0;
        $sousTotal = 0;
        $cartSize = 0;

        if(!empty($panier[$id])){
            $panier[$id] = $nb;
            $sousProduct = $productRepository->find($id)->getPrice() * $nb;
            foreach($panier as $id => $quantity ){
                $sousTotal += $productRepository->find($id)->getPrice() * $quantity;
                $cartSize +=  $quantity;
            }
        }

        $session->set('panier', $panier);

        return new JsonResponse(["sousProduct"=>$sousProduct, "sousTotal"=>$sousTotal,"cartSize"=>$cartSize]);
    }
}
