<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginUserType extends AbstractType
{

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.login.email.label',
                'attr' => [
                    'placeholder' => 'user.login.email.placeholder',
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'user.login.password.label',
                'attr' => [
                    'placeholder' => 'user.login.password.placeholder',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'user.login.submit.label',
                'attr' => [
                    'placeholder' => 'user.login.placeholder',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'action' => $this->urlGenerator->generate('admin_login_submit'),
            'method' => 'post',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'authenticate',
        ]);
    }
}
