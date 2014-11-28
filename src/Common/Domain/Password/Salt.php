<?php

namespace Afsy\Common\Domain\Password;

class Salt
{
    private $value;

    public function __construct()
    {
        $this->value = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function __toString()
    {
        return $this->value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
