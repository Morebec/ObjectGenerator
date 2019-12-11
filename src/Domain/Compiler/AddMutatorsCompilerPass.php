<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * AddMutatorsCompilerPass
 */
class AddMutatorsCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
    }

    public function processDefinition(ObjectDefinition $definition)
    {
        foreach ($definition->getProperties() as $propertyDefinition) {
            $mutator = $propertyDefinition->getMutator();
            if (!$mutator) {
                continue;
            }
            $definition->addMethod($mutator);
        }
    }
}
