<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function liste(): Response
    {
        return $this->render('home.html.twig', [
        ]);
    }

    #[Route('/', name: 'default')]
    public function index(): RedirectResponse
    {
        // Redirige vers la route nommée 'home'
        return $this->redirectToRoute('home');
    }

    #[Route('/product/{id}/show', name: 'product.show',methods: ['GET', 'POST'])]
    public function show($id, ProductRepository $ProductRepository): Response
    {
        $product = $ProductRepository->find($id);

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'product.edit',methods: ['GET', 'POST'])]
    public function edit(Product $product, AuthorizationCheckerInterface $authorizationChecker, Request $request, EntityManagerInterface $em): Response
    {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $em->flush();
            $this->addFlash('success','Les modifications ont été enregistrées');
            return $this->redirectToRoute( 'product.show', ["id"=> $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,'form'=>$form
        ]);
    }

    #[Route('/product/create', name: 'product.create',methods: ['GET', 'POST'])]
    public function create(AuthorizationCheckerInterface $authorizationChecker, Request $request, EntityManagerInterface $em): Response
    {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $brand = $product->getBrand();
            $image = $product->getImage();

            if ($brand && !$em->contains($brand)) {
                $em->persist($brand);
            }

            if ($image && !$em->contains($image)) {
                $em->persist($image);
            }

            $em->persist($product);
            $em->flush();
            $this->addFlash('success','Les parfum a été enregistré');
            return $this->redirectToRoute('manageProduct');
        }

        return $this->render('product/create.html.twig', [
            'form'=>$form
        ]);
    }

    #[Route('/product/{id}/remove', name: 'product.remove',methods: ['DELETE'])]
    public function remove(Product $product, AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $em){
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home');
        }

        try{
            $em->remove($product);
            $em->flush();
            $this->addFlash('success','Le produit a bien été supprimé.');
        }catch (\Exception $e){
            $this->addFlash('danger','Le produit ne peut pas être supprimé.');
        }

        return $this->redirectToRoute('home');
    }


}
