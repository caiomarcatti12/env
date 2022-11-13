<?php

namespace CaioMarcatti12\Env\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Value
{
    private string $property;
    private mixed $valueDefault = null;

    public function __construct(string $property, mixed $valueDefault = null)
    {
        $this->property = $property;
        $this->valueDefault = $valueDefault;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getValueDefault(): mixed
    {
        return $this->valueDefault;
    }
}