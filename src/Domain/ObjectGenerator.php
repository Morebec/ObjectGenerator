<?php

namespace Morebec\ObjectGenerator\Domain;


use Morebec\ObjectGenerator\Domain\Compiler\Compiler;
use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Morebec\ObjectGenerator\Domain\Definition\Schema\ObjectDefinitionSchema;
use Morebec\ObjectGenerator\Domain\Loader\DefinitionLoaderInterface;
use Morebec\ObjectGenerator\Domain\ObjectReferenceDumper\ObjectReferenceDumperInterface;
use Morebec\ValueObjects\File\File;
use Symfony\Component\Config\Definition\Processor;

/**
 * TypeGenerator
 */
class ObjectGenerator
{
    /**
     * @var DefinitionLoaderInterface
     */
    private $loader;
    /**
     * @var ObjectReferenceDumperInterface
     */
    private $dumper;

    public function __construct(
        DefinitionLoaderInterface $loader,
        ObjectReferenceDumperInterface $dumper
    ) {
        $this->loader = $loader;
        $this->dumper = $dumper;
    }

    public function generateFile(File $file): ObjectGenerationResult
    {
        // Load definition data schema
        $data = $this->loader->loadDefinitionFile($file);
        
        $result = $this->generateFromArraySchema($data);
        $result->setInitialSchema($data);
        return $result;
    }
    
    public function generateFromArraySchema(array $schema): ObjectGenerationResult
    {
        $typeName = array_key_first($schema);
        $objectSchema = new ObjectDefinitionSchema($typeName);

        // Validate schema against schema validator
        $processor = new Processor();
        $validatedArraySchema = $processor->processConfiguration(
            $objectSchema,
            $schema
        );

        // Create definition object
        $definition = ObjectDefinition::createFromArray(
            $typeName,
            $validatedArraySchema
        );
        
        $result = $this->generateFromObjectDefinition($definition);
        $result->setValidatedSchema($schema);
        return $result;
    }
    
    public function generateFromObjectDefinition(ObjectDefinition $definition): ObjectGenerationResult
    {
        // Compile Schema into class representation
        $compiler = new Compiler();
        $object = $compiler->compile($definition);

        // Generate code
        $result = new ObjectGenerationResult(null, null, $definition, $object);
        return $result;
    }

    /**
     * Dumps a reference
     * @return string
     */
    public function dumpReference(): string
    {
        $objectSchema = new ObjectDefinitionSchema('ClassName');
        return $this->dumper->dump($objectSchema);
    }
}
