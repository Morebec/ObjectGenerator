<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

use Morebec\ObjectGenerator\Domain\Definition\Schema\SchemaKey;

/**
 * ParamDefinition
 */
class ParameterDefinition
{
    /** @var string */
    private $name;

    private $default;

    /** @var string */
    private $description;

    /** @var array */
    private $annotations;

    /** @var bool */
    private $initialize;
    
    /** @var VariableType */
    private $type;


    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of 'default'
     * @return void
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the value of name
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the value of 'default'
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Returns the value of 'description'
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns the value of 'annotations'
     * @return array
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * Returns the value of 'initialize'
     * @return bool
     */
    public function getInitialize(): bool
    {
        return $this->initialize;
    }

    public function setDefault($default): void
    {
        $this->default = $default;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAnnotations(array $annotations): void
    {
        $this->annotations = $annotations;
    }

    public function setInitialize(bool $initialize): void
    {
        $this->initialize = $initialize;
    }

    /**
     * Returns the type as passed in the type configuration.
     * This version of type is to be displayed in documentation strings
     * @return VariableType
     */
    public function getType(): VariableType
    {
        return $this->type;
    }

    /**
     * Sets the type
     * @param VariableType $type
     * @return void
     */
    public function setType(VariableType $type): void
    {
        $this->type = $type;
    }

    /**
     * Indicates if the type is nullable
     * @return bool
     */
    public function isTypeNullable(): bool
    {
        return $this->type->isNullable();
    }

    /**
     * Returns the base type, meaning in cases where type
     * is int|null will only return the int portion
     * if string[] will return array
     * if string|int|null will return mixed
     * This type is used to be displayed before to the parameter name in code.
     * @return string|null
     */
    public function getBaseType(): string
    {
        return $this->type->getBaseType();
    }

    /**
     * Creates a parameter definition from an array
     * @param string $parameterName
     * @param array $data
     * @return ParameterDefinition
     */
    public static function createFromArray(
        string $parameterName,
        array $data
    ): self {
        $definition = new static($parameterName);
        $definition->setDefault($data[SchemaKey::DEFAULT]);
        $definition->setDescription($data[SchemaKey::DESCRIPTION]);
        $definition->setAnnotations($data[SchemaKey::ANNOTATIONS]);
        $definition->setInitialize($data[SchemaKey::INITIALIZE]);
        $definition->setType(VariableType::fromString($data[SchemaKey::TYPE]));
        
        return $definition;
    }
}
