<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $page = $request->query->getInt('page',1);
        $users = $userRepository->paginateUser($page);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
