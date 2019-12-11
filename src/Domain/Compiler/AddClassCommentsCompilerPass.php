<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * AddClassCommentsCompilerPass
 */
class AddClassCommentsCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
        // Comment
        $class->addComment($definition->getDescription());

        // Annotations
        $annotations = $definition->getAnnotations();
        if (!empty($annotations)) {
            $class->addComment('');
        }
        foreach ($annotations as $annotation) {
            $class->addComment($annotation);
        }
    }

    public function processDefinition(ObjectDefinition $def)
    {
    }
}
