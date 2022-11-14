<?php

namespace CaioMarcatti12\Env\Resolver;


use CaioMarcatti12\Core\Bean\Annotation\AnnotationResolver;
use CaioMarcatti12\Core\Bean\Interfaces\PropertyResolverInterface;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Env\Annotation\Value;
use CaioMarcatti12\Env\Exception\PropertyNotFoundException;
use CaioMarcatti12\Env\Objects\Property;
use ReflectionProperty;

#[AnnotationResolver(Value::class)]
class ValueResolver implements PropertyResolverInterface
{
    public function handler(object &$instance, ReflectionProperty $reflectionProperty): void {
        $attributes = $reflectionProperty->getAttributes(Value::class);

        /** @var \ReflectionAttribute $attribute */
        $attribute = array_shift($attributes);

        /** @var Value $instanceAttribute */
        $instanceAttribute = $attribute->newInstance();

        $property = $instanceAttribute->getProperty();
        $valueDefault = $instanceAttribute->getValueDefault();

        $value = Property::get($property, $valueDefault);

        if (!Assert::isEmpty($property) && Assert::isNull($valueDefault) && Assert::isEmpty($value)) throw new PropertyNotFoundException($property);

        $reflectionProperty->setValue($instance, $value);
    }
}