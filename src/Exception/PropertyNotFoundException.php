<?php
namespace CaioMarcatti12\Env\Exception;

use Exception;

class PropertyNotFoundException extends Exception
{
    public function __construct($property = "")
    {
        parent::__construct('Property not found: '. $property, 500, null);
    }
}