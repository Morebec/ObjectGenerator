<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\MethodDefinition;
use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Morebec\ObjectGenerator\Domain\Definition\ParameterDefinition;
use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;

/**
 * AddMethodsCompilerPass
 */
class AddMethodsCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
        foreach ($definition->getMethods() as $methodDefinition) {
            $method = $this->addMethod($class, $methodDefinition);
            
            // Annotations
            $annotations = $methodDefinition->getAnnotations();
            if (!empty($annotations)) {
                $method->addComment('');
            }
            foreach ($annotations as $annotation) {
                $method->addComment($annotation);
            }
            if (!empty($annotations)) {
                $method->addComment('');
            }
            
            $this->addParametersToMethod($method, $methodDefinition);
            
            $this->addReturnType($method, $methodDefinition);
        }
    }

    protected function addMethod(
        ClassType $class,
        MethodDefinition $methodDefinition
    ): Method {
        $classMethod = $class->addMethod($methodDefinition->getName());
        $classMethod->setStatic($methodDefinition->getStatic());
        $classMethod->setAbstract($methodDefinition->getAbstract());
        $classMethod->setFinal($methodDefinition->getFinal());
        $classMethod->setVisibility($methodDefinition->getVisibility());

        // Comment on method
        $classMethod->addComment($methodDefinition->getDescription());

        $code = $methodDefinition->getCode();
        if (!$code && $class->getType() !== 'interface') {
            $code = '';
        }
        
        $classMethod->setBody($code);
        
        return $classMethod;
    }
    
    protected function addParametersToMethod(
        Method $method,
        MethodDefinition $methodDefinition
    ): void {
        foreach ($methodDefinition->getParameters() as $parameterDefinition) {
            $this->addParameter($method, $parameterDefinition);
        }
    }
    
    protected function addParameter(
        Method $method,
        ParameterDefinition $parameterDefinition
    ): void {
        $param = $method->addParameter($parameterDefinition->getName());
        

        // Base Type
        $baseType = $parameterDefinition->getBaseType();
        if ($baseType !== VariableType::UNDEFINED && $baseType !== 'mixed') {
            $param->setType($baseType);
        }

        // Nullable
        $param->setNullable($parameterDefinition->isTypeNullable());
        
        // default value
        $defaultValue = $parameterDefinition->getDefault();
        if ($defaultValue !== VariableType::UNDEFINED) {
            $param->setDefaultValue($defaultValue);
        }

        // Comment
        $docParamWord = '@param';
        $docParamType = $parameterDefinition->getType()->getDocBlockType();
        $docParamName = '$' . $parameterDefinition->getName();
        $docParamDesc = $parameterDefinition->getDescription();
        $comment = "$docParamWord $docParamType $docParamName $docParamDesc";
        $method->addComment($comment);
    }
    
    protected function addReturnType(
        Method $method,
        MethodDefinition $methodDefinition
    ): void {
        if ($method->getName() === '__construct') {
            return;
        }
        
        $returnDefinition = $methodDefinition->getReturnType();
        
        $type = $returnDefinition->getType();
        if (!$type) {
            return;
        }

        // Base Type
        if (!$type->isMixed() && !$type->isUndefined()) {
            $method->setReturnType($type->getBaseType());
        }
        
        // Nullable
        $method->setReturnNullable($returnDefinition->isTypeNullable());
        
        // Comment
        $docParamType = $type->getDocBlockType();
        $description = $returnDefinition->getDescription();
        $method->addComment("@return $docParamType $description");
    }
    
    public function processDefinition(ObjectDefinition $definition)
    {
    }
}
