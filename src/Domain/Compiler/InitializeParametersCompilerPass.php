<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * InitialieParametersCompilerPass
 */
class InitializeParametersCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
    }

    public function processDefinition(ObjectDefinition $definition)
    {
        foreach ($definition->getMethods() as $methodDefinition) {
            foreach ($methodDefinition->getParameters() as $parameterDefinition) {
                if ($parameterDefinition->getInitialize()) {
                    // Generate Initialization code
                    $parameterName = $parameterDefinition->getName();
                    $initializationCode = sprintf('$this->%s = $%s;', $parameterName, $parameterName);
                    
                    // Apply code
                    $code = $methodDefinition->getCode();
                    $finalCode = "$initializationCode\n$code";
                    $methodDefinition->setCode($finalCode);
                }
            }
        }
    }
}
