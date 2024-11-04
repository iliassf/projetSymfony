<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\OrderItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AuthorizationCheckerInterface $authorizationChecker, ProductRepository $productRepository, OrderRepository $orderRepository, OrderItemRepository $orderItemRepository): Response
    {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        $productsByCateg = $productRepository->countProductsByCategory();
        $productsByStatus = $productRepository->countProductsByStatus();
        $fiveLatestOrder = $orderRepository->fiveLatestOrder();
        $totalAmountByMonth = $orderItemRepository->totalAmountByMonth();

        return $this->render('dashboard/index.html.twig', [
            'productsByCategory' => $productsByCateg,
            'productsByStatus' => $productsByStatus,
            'fiveLatestOrder' => $fiveLatestOrder,
            'totalAmountByMonth' => $totalAmountByMonth
        ]);
    }
}
