<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{

    #[Route('/login',
        name: 'admin_login',
        host: 'admin.%app.base_host%',
        methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/login/index.html.twig');
    }

}