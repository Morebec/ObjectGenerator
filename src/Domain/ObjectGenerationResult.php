<?php

namespace Morebec\ObjectGenerator\Domain;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * Container for the different data structures created
 * during the generation of an object.
 * It contains:
 *   * The initial configuration object received
 *   * The validated configuration object agains the configuration schema
 *   * The Object's definition
 *   * The generated object class
 */
final class ObjectGenerationResult
{
    /** @var array|null initial configuration object received initial configuration object received */
    private $initialSchema;

    /** @var array|null validated schema validated schema */
    private $validatedSchema;

    /** @var ObjectDefinition Object's definition Object's definition */
    private $definition;

    /** @var ClassType Generated object */
    private $object;

    /**
     * @param array $initialSchema
     * @param array $validatedSchema
     * @param ObjectDefinition $definition
     * @param ClassType $object
     */
    public function __construct(
        ?array $initialSchema,
        ?array $validatedSchema,
        ObjectDefinition $definition,
        ClassType $object
    ) {
        $this->object = $object;
        $this->definition = $definition;
        $this->validatedSchema = $validatedSchema;
        $this->initialSchema = $initialSchema;
    }

    /**
     * Returns the value of initialSchema
     * @return array Value of initialSchema
     */
    public function getInitialSchema(): ?array
    {
        return $this->initialSchema;
    }

    /**
     * Returns the value of validatedSchema
     * @return array Value of validatedSchema
     */
    public function getValidatedSchema(): ?array
    {
        return $this->validatedSchema;
    }

    /**
     * Returns the value of definition
     * @return ObjectDefinition Value of definition
     */
    public function getDefinition(): ObjectDefinition
    {
        return $this->definition;
    }

    /**
     * Returns the value of object
     * @return ClassType Value of object
     */
    public function getObject(): ClassType
    {
        return $this->object;
    }

    /**
     * Sets the value of initialSchema
     * @param array $initialSchema new value of initialSchema
     * @return void
     */
    public function setInitialSchema(?array $initialSchema): void
    {
        $this->initialSchema = $initialSchema;
    }

    /**
     * Sets the value of validatedSchema
     * @param array $validatedSchema new value of validatedSchema
     * @return void
     */
    public function setValidatedSchema(?array $validatedSchema): void
    {
        $this->validatedSchema = $validatedSchema;
    }

    /**
     * Sets the value of definition
     * @param ObjectDefinition $definition new value of definition
     * @return void
     */
    public function setDefinition(ObjectDefinition $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * Sets the value of object
     * @param ClassType $object
     * @return void
     */
    public function setObject(ClassType $object): void
    {
        $this->object = $object;
    }
}
