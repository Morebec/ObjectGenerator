<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * Interface for compiler passes
 */
interface CompilerPassInterface
{
    /**
     * Processes a TypeDefinition before generating a class for it
     * @param ObjectDefinition $definition
     */
    public function processDefinition(ObjectDefinition $definition);
    
    /**
     * Processes the class
     * @param ClassType $class
     */
    public function processClass(ObjectDefinition $definition, ClassType $class);
}
