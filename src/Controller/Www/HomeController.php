<?php

declare(strict_types=1);

namespace App\Controller\Www;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/',
        name: 'www_home',
        host: '%app.base_host%',
        methods: ['GET'])]
    public function index () : Response {

        return $this->render('www/home/index.html.twig');

    }

}