<?php

namespace Afsy\UserProfile\Domain;

use Afsy\Common\Domain\UserIdentity;
use Afsy\Common\Domain\Event\AggregateRoot;
use Afsy\Common\Domain\Password\PlainPassword;
use Afsy\Common\Domain\Password\EncodedPassword;
use Afsy\Common\Domain\Password\Salt;

class User extends AggregateRoot
{
    private $id;

    private $firstName;

    private $lastName;

    private $emailAddress;

    private $password;

    private $salt;

    public function register(UserIdentity $userIdentity, PlainPassword $password)
    {
        $this->firstName = $userIdentity->getFirstName();
        $this->lastName = $userIdentity->getLastName();
        $this->emailAddress = $userIdentity->getEmailAddress();

        $encodedPassword = EncodedPassword::fromPlainPassword($password, (string) new Salt);
        $this->password = $encodedPassword->getValue();
        $this->salt = $encodedPassword->getSalt();

        $this->apply(
            new UserRegistered($this->id)
        );
    }

    public function authenticate(PlainPassword $password)
    {
        $encodedPassword = new EncodedPassword($this->password, $this->salt);

        if ($encodedPassword->equals(EncodedPassword::fromPlainPassword($password, $this->salt))) {
            $this->apply(
                new UserSuccessfullyAuthenticated($this->id)
            );

            return true;
        }

        $this->apply(
            new UserFailedToAuthenticate($this->id)
        );

        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdentity()
    {
        return new UserIdentity($this->firstName, $this->lastName, $this->emailAddress);
    }
}
