<?php

namespace Afsy\UserProfile\App;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Afsy\Common\Domain\Password\PlainPassword;
use Afsy\Common\Domain\UserIdentity;
use Afsy\UserProfile\Domain\User;
use Afsy\UserProfile\Domain\UserRepository;

class UserService
{
    private $userRepository;

    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registerUser(RegisterUserCommand $command)
    {
        $user = new User();
        $user->register(
            new UserIdentity(
                $command->firstName,
                $command->lastName,
                $command->emailAddress
            ),
            new PlainPassword(
                $command->password,
                $this->passwordEncoder
            )
        );

        $this->userRepository->save($user);
    }
}
