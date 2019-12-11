<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Morebec\ObjectGenerator\Domain\Definition\PropertyDefinition;
use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Nette\PhpGenerator\ClassType;

/**
 * AddPropertiesCompilerPass
 */
class AddPropertiesCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
        $properties = $definition->getProperties();
        $this->sortProperties($properties);
        foreach ($properties as  $property) {
            $this->processProperty($class, $property);
        }
    }
    
    protected function sortProperties(array &$properties)
    {
        // Sort properties const, static, public, protected, private
    }
    
    protected function processProperty(
        ClassType $class,
        PropertyDefinition $property
    ) {
        if ($property->getConstant()) {
            $prop = $class->addConstant($property->getName(), $property->getValue());
        } else {
            $prop = $class->addProperty($property->getName());
            $value = $property->getValue();
            if ($value !== VariableType::UNDEFINED) {
                $prop->setValue($value);
            }
        }

        // Visibility
        $prop->setVisibility($property->getVisibility());

        // Comment
        $type = $property->getType()->getDocBlockType();
        $description = $property->getDescription();
        $comment = trim("@var $type $description");
        $prop->addComment($comment);
    }

    public function processDefinition(ObjectDefinition $def)
    {
    }
}
