<?php

namespace App\Security;

use App\Entity\User;
use App\Form\LoginUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class LoginFormAuthenticator extends AbstractAuthenticator
{

    public function __construct(
        private readonly FormFactoryInterface $form,
        private readonly UserRepository       $userRepository,
        private readonly RouterInterface      $router
    )
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login'
            && $request->getMethod() === 'POST';
    }

    public function authenticate(Request $request): Passport
    {
        $user = new User();

        $form = $this->form->create(LoginUserType::class, $user);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $form->getData();

        $userBadge = new UserBadge(
            $user->getEmail(),
            function ($userIdentifier) {
                if (!$user = $this->userRepository->findOneBy([
                    'email' => $userIdentifier
                ])) {
                    throw new UserNotFoundException();
                }

                return $user;
            }
        );

        return new Passport(
            $userBadge,
            new PasswordCredentials($user->getPlainPassword())
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('admin_main'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse($this->router->generate('admin_login'));
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
