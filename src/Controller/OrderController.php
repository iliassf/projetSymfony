<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\OrderRepository;

use App\Entity\OrderItem;
use App\Entity\Order;
use App\Enum\Available;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Enum\Step;

use Doctrine\ORM\EntityManagerInterface;


class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $orders = $orderRepository->paginateOrder($page);

        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/sendOrder', name: 'order.send')]
    public function sendOrder(
        SessionInterface $session,
        ProductRepository $productRepository,
        EntityManagerInterface $manager
    ): Response {
        $panier = $session->get('panier', []);
    
        if (!empty($panier)) {
            $date = new \DateTimeImmutable();
    
            $order = new Order();
            $user = $this->getUser();
            
            $order->setUser($user);
            $order->setReference(uniqid('ORD_'));
            $order->setCreatedAt($date);
            $order->setStatus(Step::Preparation);
    
            $manager->persist($order);
    
            foreach ($panier as $productId => $quantity) {
                $product = $productRepository->find($productId);
                if ($product->getStock() >= $quantity && $product->getStatus() != "Non Disponible") {
                    $orderItem = new OrderItem();
                    $orderItem->setCommande($order);
                    $orderItem->setProduct($product);
                    $orderItem->setQuantity($quantity);
                    $orderItem->setProductPrice($product->getPrice() * $quantity);
    
                    $manager->persist($orderItem);

                    $newQuantity = $product->getStock() - $quantity;
                    $product->setStock($newQuantity);
                    if($newQuantity <= 0) {
                        $product->setStatus(Available::NonDisponible);
                    }
                    $manager->persist($product);
                }
            }
    
            $manager->flush();
    
            $session->set('panier', []);
        }
    
        return new Response('Order successfully created!', 200);
    }
}
