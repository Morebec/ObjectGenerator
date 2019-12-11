<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

use Morebec\ObjectGenerator\Domain\Definition\Schema\SchemaKey;

/**
 * MethodDefinition
 */
class MethodDefinition
{
    /**
     * @var string
     */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $visibility;

    /** @var bool */
    private $abstract;

    /** @var bool */
    private $final;

    /** @var bool */
    private $static;

    /** @var array */
    private $annotations;
    
    /** @var ParameterDefinition[] */
    private $parameters = [];
    
    /**
     * @var ?ReturnTypeDefinition
     */
    private $returnType;
    
    /**
     * Source code to add to the method, or null if nothing to add
     * @var string|null
     */
    private $code;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
     * Returns the value of 'visibility'
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * Returns the value of 'abstract'
     * @return bool
     */
    public function getAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * Returns the value of 'final'
     * @return bool
     */
    public function getFinal(): bool
    {
        return $this->final;
    }

    /**
     * Returns the value of 'static'
     * @return bool
     */
    public function getStatic(): bool
    {
        return $this->static;
    }

    /**
     * Returns the value of 'annotations'
     * @return array
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function setAbstract(bool $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function setFinal(bool $final): void
    {
        $this->final = $final;
    }

    public function setStatic(bool $static): void
    {
        $this->static = $static;
    }

    public function setAnnotations(array $annotations): void
    {
        $this->annotations = $annotations;
    }
    
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
    
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
    
    public function getReturnType(): ?ReturnTypeDefinition
    {
        return $this->returnType;
    }

    public function setReturnType(?ReturnTypeDefinition $returnType): void
    {
        $this->returnType = $returnType;
    }

    public function addParameter(ParameterDefinition $parameter): void
    {
        $this->parameters[] = $parameter;
    }
    
    /**
     * Builds a Method definition from an array
     * @param string $methodName
     * @param array $data
     * @return \self
     */
    public static function createFromArray(string $methodName, array $data): self
    {
        $definition = new static($methodName);
        $definition->setDescription($data[SchemaKey::DESCRIPTION]);
        $definition->setVisibility($data[SchemaKey::VISIBILITY]);
        $definition->setAbstract($data[SchemaKey::ABSTRACT]);
        $definition->setFinal($data[SchemaKey::FINAL]);
        $definition->setStatic($data[SchemaKey::STATIC]);
        $definition->setAnnotations($data[SchemaKey::ANNOTATIONS]);
        $definition->setCode($data[SchemaKey::CODE]);
        
        $definition->setReturnType(
            new ReturnTypeDefinition(
                VariableType::fromString($data[SchemaKey::RETURN][SchemaKey::TYPE]),
                $data[SchemaKey::RETURN][SchemaKey::DESCRIPTION]
            )
        );

        foreach ($data[SchemaKey::PARAMETERS] as $parameterName => $parameter) {
            $definition->addParameter(
                ParameterDefinition::createFromArray($parameterName, $parameter)
            );
        }
        
        return $definition;
    }
}
