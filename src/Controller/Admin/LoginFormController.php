<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\LoginUserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginFormController extends AbstractController
{

    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);

        if($email = $authenticationUtils->getLastUsername()){
            $form->get('email')->setData($email);
        }

        return $this->render('admin/login_form/index.html.twig', [
            'form' => $form,
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/login/submit',
        name: 'admin_login_submit',
        host: 'admin.%app.base_host%',
        methods: ['POST'])]
    public function login (): never {
        throw new Exception('login() should never be reached');
    }

}
