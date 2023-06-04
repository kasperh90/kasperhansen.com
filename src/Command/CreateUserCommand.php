<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'create-user',
    description: 'This creates an admin user',
)]
class CreateUserCommand extends Command
{

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $plaintextPassword = $input->getArgument('password');

        $user = new User($email);
        $user->setEmail($email);

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        $user->setPassword($hashedPassword);

        $errors = $this->validator->validate($user);

        if (count($errors)) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
            }

            return Command::INVALID;
        }

        $this->userRepository->save($user, true);

        $io->success('The user has been created successfully' . $hashedPassword);

        return Command::SUCCESS;
    }
}
