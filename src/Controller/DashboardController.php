<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\OrderItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AuthorizationCheckerInterface $authorizationChecker, ProductRepository $productRepository, OrderRepository $orderRepository, OrderItemRepository $orderItemRepository,RequestStack $requestStack): Response
    {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        $request = $requestStack->getCurrentRequest();

        $productsByCateg = $productRepository->countProductsByCategory();
        $productsByStatus = $productRepository->countProductsByStatus();
        $fiveLatestOrder = $orderRepository->fiveLatestOrder();
        $totalAmountByMonth = $orderItemRepository->totalAmountByMonth($request->getLocale());

        return $this->render('dashboard/index.html.twig', [
            'productsByCategory' => $productsByCateg,
            'productsByStatus' => $productsByStatus,
            'fiveLatestOrder' => $fiveLatestOrder,
            'totalAmountByMonth' => $totalAmountByMonth
        ]);
    }
}
