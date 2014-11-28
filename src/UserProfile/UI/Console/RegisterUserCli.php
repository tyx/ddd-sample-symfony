<?php

namespace Afsy\UserProfile\UI\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Afsy\UserProfile\App\UserService;
use Afsy\UserProfile\App\RegisterUserCommand;

class RegisterUserCli extends Command
{
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    protected function configure()
    {
        $this
            ->setName('afsy:user:register')
            ->addArgument('firstName', InputArgument::REQUIRED, 'User firstName')
            ->addArgument('lastName', InputArgument::REQUIRED, 'User lastName')
            ->addArgument('emailAddress', InputArgument::REQUIRED, 'User emailAddress')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->userService->registerUser(
            new RegisterUserCommand(
                $input->getArgument('firstName'),
                $input->getArgument('lastName'),
                $input->getArgument('emailAddress'),
                $input->getArgument('password')
            )
        );
    }
}
