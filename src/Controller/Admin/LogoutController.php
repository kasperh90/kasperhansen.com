<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\LoginUserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogoutController extends AbstractController
{

    #[Route('/logout',
        name: 'admin_logout',
        host: 'admin.%app.base_host%',
        methods: ['GET'])]
    public function index(AuthenticationUtils $authenticationUtils): never
    {

        throw new Exception('logout() should never be reached');

    }

}