<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'productById',methods: ['GET', 'POST'])]
    public function index($id, ProductRepository $ProductRepository): Response
    {
        $product = $ProductRepository->find($id);

        return $this->render('description.html.twig', [
            'product' => $product,
        ]);
    }
}
