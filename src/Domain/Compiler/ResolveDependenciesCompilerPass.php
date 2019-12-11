<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Morebec\ObjectGenerator\Domain\DependencyResolver;
use Nette\PhpGenerator\ClassType;

/**
 * ResolveDependenciesCompilerPass
 */
class ResolveDependenciesCompilerPass implements CompilerPassInterface
{
    public function processClass(ObjectDefinition $definition, ClassType $class)
    {
    }

    public function processDefinition(ObjectDefinition $definition)
    {
        $types = $this->findAllTypes($definition);
        
        $declaredObjects = (new DependencyResolver())->getDeclaredClasses();
        
        $resolved = [];
        $unresolved = [];
        foreach ($types as $t) {
            $candidates = array_filter($declaredObjects, static function ($o) use ($t) {
                // $o (the namespace) Ends with the type ($t)
                $len = strlen($t);
                return substr($o, -$len) == "$t";
            });
                        
            $nbCandidates = count($candidates);
            if ($nbCandidates > 1) {
                $unresolved[$t] = $candidates;
                continue;
            }
            
            if ($nbCandidates === 0) {
                $unresolved[$t] = [];
                continue;
            }
            
            $type = array_values($candidates)[0];
            
            // Check if there is a namespace or if it is part of standard library
            
            $resolved[] = $type;
        }
       
        $definition->setUnresolvedDependencies($unresolved);
        $definition->setUse($resolved);
    }
    
    /**
     * Finds all the types used in the definition
     * @param ObjectDefinition $definition
     * @return array
     */
    private function findAllTypes(ObjectDefinition $definition): array
    {
        $typesNonUnique = array_merge(
            $this->findMethodParameterTypes($definition),
            $this->findPropertyTypes($definition)
        );

        $typesUnique = array_keys(array_flip($typesNonUnique));


        // Filter out the undefined type and primitives
        $types = array_filter($typesUnique, static function ($t) {
            return $t !== VariableType::UNDEFINED && !in_array($t, VariableType::PRIMITIVES);
        });
        
        return $types;
    }
    
    /**
     * Checks all arguments of all methods to find out the needed types
     * @param ObjectDefinition $definition
     * @return array
     */
    private function findMethodParameterTypes(ObjectDefinition $definition): array
    {
        $methods = $definition->getMethods();
        $types = [];
        foreach ($methods as $method) {
            foreach ($method->getParameters() as $param) {
                $types[] = $param->getType()->getBaseType();
            }
        }
        return $types;
    }
    
    /**
     * Checks all the arguments of all methods to find out the needed types
     * @param ObjectDefinition $definition
     * @return array
     */
    private function findPropertyTypes(ObjectDefinition $definition): array
    {
        $props = $definition->getProperties();
        $types = [];
        foreach ($props as $prop) {
            $types[] = $prop->getType()->getBaseType();
        }
        return $types;
    }
}
