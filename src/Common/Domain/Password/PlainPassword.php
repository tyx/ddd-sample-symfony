<?php

namespace Afsy\Common\Domain\Password;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PlainPassword
{
    private $value;

    private $encoder;

    public function __construct($value, PasswordEncoderInterface $encoder)
    {
        $this->value = (string) $value;
        $this->encoder = $encoder;
    }

    public function encode($salt)
    {
        return $this->encoder->encodePassword($this->value, $salt);
    }
}
