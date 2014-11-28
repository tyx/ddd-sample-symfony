<?php

namespace Afsy\UserProfile\App;

use Afsy\UserProfile\Domain\UserRepository;

class UserQueryService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function user($userId)
    {
        $user = $this->userRepository->find($userId);

        if (null === $user) {
            throw new UserNotFoundException(sprintf('No user found with id #%s', $userId));
        }

        return $user;
    }
}
