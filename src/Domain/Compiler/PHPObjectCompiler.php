<?php

namespace Morebec\ObjectGenerator\Domain\Compiler;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * Compiler
 */
class PHPObjectCompiler
{
    /**
     * @var CompilerPassInterface[]
     */
    private $compilerPasses;

    public function __construct(array $compilerPasses = [])
    {
        $this->compilerPasses = array_merge($compilerPasses, [
            new AddAccessorsCompilerPass(),
            new AddMutatorsCompilerPass(),
            new InitializeParametersCompilerPass(),
            
            // new DebugDefinitionCompilerPass(),
            
            // new ResolveDependenciesCompilerPass(),
            
            new AddClassCommentsCompilerPass(),
            new AddClassInfoCompilerPass(),
            new AddPropertiesCompilerPass(),
            new AddMethodsCompilerPass()
        ]);
    }
    
    public function compile(ObjectDefinition $definition): ClassType
    {
        // Definition processing
        foreach ($this->compilerPasses as $pass) {
            $pass->processDefinition($definition);
        }
        
        $class = new ClassType($definition->getName());
        $class->setType($definition->getType());
        
        // Class processing
        foreach ($this->compilerPasses as $pass) {
            $pass->processClass($definition, $class);
        }

        return $class;
    }
}
