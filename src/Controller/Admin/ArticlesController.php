<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles',
        name: 'admin_articles',
        host: 'admin.%app.base_host%',
        methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }
}
