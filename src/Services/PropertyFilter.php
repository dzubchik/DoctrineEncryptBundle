<?php
declare(strict_types=1);

namespace Paymaxi\DoctrineEncryptBundle\Services;

use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class PropertyFilter
 *
 * @package Paymaxi\DoctrineEncryptBundle\Services
 */
final class PropertyFilter
{
    /**
     * @param ClassMetadata $metadata
     *
     * @return array
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \ReflectionException
     */
    public static function filter(ClassMetadata $metadata):array
    {
        $reflectionClass = $metadata->getReflectionClass();
        $propertyArray = $reflectionClass->getProperties();
        $properties    = [];

        foreach ($propertyArray as $property) {
            $ref = new \ReflectionClass($metadata);
            $embeddedProp = $ref->getProperty('embeddedClasses');
            $embeddedProp->setAccessible(true);
            $embeddedClasses = $embeddedProp->getValue($metadata);

            $propertyName = $property->getName();
            if (isset($embeddedClasses[$propertyName])) {
                continue;
            }

            if (!$metadata->hasField($propertyName) || $metadata->isInheritedEmbeddedClass($propertyName)) {
                continue;
            }

            $fieldMetadata = $metadata->getFieldMapping($propertyName);
            if (isset($fieldMetadata['options']['encrypt'])) {
                $properties[] = $property;
            }
        }

        return $properties;
    }
}
