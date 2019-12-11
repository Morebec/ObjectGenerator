<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * ApplyClassInfoCompilerPass
 */
class AddClassInfoCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
        if ($definition->getAbstract()) {
            $class->setAbstract();
        }
        
        if ($definition->getFinal()) {
            $class->setFinal();
        }

        // Extends
        $parent = $definition->getExtends();
        if ($parent) {
            $class->setExtends($parent);
        }

        // Interfaces
        foreach ($definition->getImplements() as $interface) {
            $class->addImplement($interface);
        }

        // Traits
        foreach ($definition->getTraits() as $trait) {
            $class->AddTrait($trait);
        }
    }

    public function processDefinition(ObjectDefinition $def)
    {
    }
}
