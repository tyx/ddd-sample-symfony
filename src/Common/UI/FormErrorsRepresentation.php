<?php

namespace Afsy\Common\UI;

class FormErrorsRepresentation
{
    private $errors = array();

    public function __construct($formErrors)
    {
        foreach ($formErrors as $property => $error) {
            $this->errors[] = array(
                'description' => $error,
                'property'   => $property
            );
        }
    }

    public function __toString()
    {
        return json_encode($this->errors);
    }
}
