<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/',
        name: 'admin_main',
        host: 'admin.%app.base_host%',
        methods: ['GET'])]
    public function index(): Response
    {

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);

        return $response;

    }

}