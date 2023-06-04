<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogoutController extends AbstractController
{

    /**
     * @throws Exception
     */
    #[Route('/logout',
        name: 'admin_logout',
        host: 'admin.%app.base_host%',
        methods: ['GET'])]
    public function logout(AuthenticationUtils $authenticationUtils): never
    {
        throw new Exception('logout() should never be reached');
    }

}