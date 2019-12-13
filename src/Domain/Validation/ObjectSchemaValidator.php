<?php


namespace Morebec\ObjectGenerator\Domain\Validation;

use Morebec\ObjectGenerator\Domain\Definition\Schema\ObjectDefinitionSchema;
use Symfony\Component\Config\Definition\Processor;

/**
 * Validates the data of a loaded schema
 * before converting it to a schema
 */
class ObjectSchemaValidator
{
    /**
     * Validates the array data of an Object definition loaded from file
     * and returns a sanitized version of it
     * @param array $data
     * @return array
     */
    public function validate(string $objectName, array $data): array {
        $typeName = array_key_first($data);
        $objectSchema = new ObjectDefinitionSchema($objectName);

        $processor = new Processor();
        return $processor->processConfiguration(
            $objectSchema,
            $data
        );
    }
}