<?php


namespace Morebec\ObjectGenerator\Application\Shared\Service;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Morebec\ObjectGenerator\Domain\ObjectDumper;
use Morebec\ObjectGenerator\Domain\ObjectGenerationResult;
use Morebec\ObjectGenerator\Domain\ObjectGenerator;
use Morebec\ObjectGenerator\Infrastructure\Loader\YamlDefinitionLoader;
use Morebec\ObjectGenerator\Infrastructure\ObjectReferenceDumper\YamlObjectReferenceDumper;
use Morebec\ValueObjects\File\File;

/**
 * Entry point for clients to the domain
 */
class ApplicationService
{
    /**
     * Compiles a file and returns an ObjectGenerationResult
     * @param string $pathToFile
     * @return ObjectGenerationResult
     */
    public function compileFile(string $pathToFile): ObjectGenerationResult
    {
        return $this->getObjectGenerator()->generateFile(File::fromStringPath($pathToFile));
    }

    /**
     * Compiles a definition and returns an ObjectGenerationResult
     * @param ObjectDefinition $definition
     * @return ObjectGenerationResult
     */
    public function compileDefinition(ObjectDefinition $definition): ObjectGenerationResult
    {
        return $this->getObjectGenerator()->generateFromObjectDefinition($definition);
    }

    /**
     * Returns a string contaning the reference for Objects as Yaml
     * @return string
     */
    public function dumpReference(): string
    {
        return $this->getObjectGenerator()->dumpReference();
    }

    /**
     * Dumps an Object
     * @param ObjectGenerationResult $object
     * @return string
     */
    public function dumpObjectFromObjectGenerationResult(ObjectGenerationResult $object): string
    {
        return ObjectDumper::dumpObjectGenerationResult($object);
    }

    /**
     * Returns an instance of ObjectGenerator using a YamlDefinitionLoader
     * @return ObjectGenerator
     */
    private function getObjectGenerator(): ObjectGenerator
    {
        $dumper = new YamlObjectReferenceDumper();
        $loader = new YamlDefinitionLoader();
        return new ObjectGenerator($loader, $dumper);
    }
}