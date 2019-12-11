<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * DebugDefinitionCompilerPass
 */
class DebugDefinitionCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
    }

    public function processDefinition(ObjectDefinition $definition)
    {
        var_dump($definition);
        exit;
    }
}
