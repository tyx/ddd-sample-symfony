<?php

namespace Afsy\Common\Domain\Password;

class EncodedPassword
{
    private $value;

    private $salt;

    public function __construct($value, $salt)
    {
        $this->value = $value;
        $this->salt = $salt;
    }

    static public function fromPlainPassword(PlainPassword $password, $salt)
    {
        return new EncodedPassword(
            $password->encode($salt),
            $salt
        );
    }

    public function equals(EncodedPassword $encodedPassword)
    {
        return
            $encodedPassword->getValue() === $this->value &&
            $encodedPassword->getSalt() === $this->salt
        ;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSalt()
    {
        return $this->salt;
    }
}
