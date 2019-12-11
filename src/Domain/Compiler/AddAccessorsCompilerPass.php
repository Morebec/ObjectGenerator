<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * AddAccessorsCompilerPass
 */
class AddAccessorsCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
    }

    public function processDefinition(ObjectDefinition $definition)
    {
        foreach ($definition->getProperties() as $propertyDefinition) {
            $accessor = $propertyDefinition->getAccessor();
            if (!$accessor) {
                continue;
            }
            $definition->addMethod($accessor);
        }
    }
}
