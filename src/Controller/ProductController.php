<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function liste(ProductRepository $ProductRepository): Response
    {
        $product = $ProductRepository->findAll();

        return $this->render('home.html.twig',['product' => $product]);
    }

    #[Route('/', name: 'default')]
    public function index(): RedirectResponse
    {
        // Redirige vers la route nommée 'home'
        return $this->redirectToRoute('home');
    }

    #[Route('/product/{id}', name: 'productById',methods: ['GET', 'POST'])]
    public function productById($id, ProductRepository $ProductRepository): Response
    {
        $product = $ProductRepository->find($id);

        return $this->render('description.html.twig', [
            'product' => $product,
        ]);
    }
}
