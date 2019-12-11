<?php


namespace Morebec\ObjectGenerator\Domain\ObjectReferenceDumper;

use Morebec\ObjectGenerator\Domain\Definition\Schema\ObjectDefinitionSchema;

/**
 * Object Reference dumpers are responsible for dumping
 * the reference of Object definition in a specific format
 */
interface ObjectReferenceDumperInterface
{
    /**
     * Dumps a provided ObjectDefinitionSchema to a string
     * @param ObjectDefinitionSchema $schema
     * @return string
     */
    public function dump(ObjectDefinitionSchema $schema): string;
}