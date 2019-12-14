<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

use Morebec\ObjectGenerator\Domain\Definition\Schema\SchemaKey;
use mysql_xdevapi\Schema;

class ObjectDefinition
{
    /** @var string|null */
    private $namespace;
    
    /** @var string */
    private $name;

    /** @var bool */
    private $final = false;

    /** @var bool */
    private $abstract = false;

    /** @var string */
    private $type = 'class';

    /** @var string */
    private $description = '';

    /** @var string|null */
    private $extends;

    /** @var string[] */
    private $implements = [];

    /** @var string[] */
    private $traits = [];

    /** @var string[] */
    private $annotations = [];
    
    /** @var string[] */
    private $use = [];

    /** @var PropertyDefinition[] */
    private $properties = [];

    /** @var array */
    private $methods = [];
    
    /**
     * List of all the unresolved dependencies for this type definition
     *  @var string[]
     */
    private $unresolvedDependencies = [];

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
     * Returns the value of 'final'
     * @return bool
     */
    public function getFinal(): bool
    {
        return $this->final;
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
     * Returns the value of 'type'
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
     * Returns the value of 'extends'
     * @return string
     */
    public function getExtends(): ?string
    {
        return $this->extends;
    }

    /**
     * Returns the value of 'implements'
     * @return array
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * Returns the value of 'traits'
     * @return array
     */
    public function getTraits(): array
    {
        return $this->traits;
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
     * Returns the value of 'properties'
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Returns the value of 'methods'
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function setFinal(bool $final): void
    {
        $this->final = $final;
    }

    public function setAbstract(bool $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setExtends(?string $extends): void
    {
        $this->extends = $extends;
    }

    public function setImplements(array $implements): void
    {
        $this->implements = $implements;
    }

    public function setTraits(array $traits): void
    {
        $this->traits = $traits;
    }

    public function setAnnotations(array $annotations): void
    {
        $this->annotations = $annotations;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    public function setMethods(array $methods): void
    {
        $this->methods = $methods;
    }
    
    public function addMethod(MethodDefinition $def): void
    {
        $this->methods[] = $def;
    }
    
    public function addProperty(PropertyDefinition $property)
    {
        $this->properties[] = $property;
    }
    
    public function addAnnotation(string $annotation): void
    {
        $this->annotations[] = $annotation;
    }
    
    public function getUse(): array
    {
        return $this->use;
    }

    public function setUse(array $use): void
    {
        $this->use = $use;
    }
    
    public function addUse(UseDefinition $use): void
    {
        $this->use[] = $use;
    }
    
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function setNamespace(?string $namespace): void
    {
        $this->namespace = $namespace;
    }
    
    public function hasNamespace(): bool
    {
        return $this->namespace !== null;
    }

    public function setUnresolvedDependencies($unresolved)
    {
        $this->unresolvedDependencies = $unresolved;
    }

    public function getUnresolvedDependencies(): array
    {
        return $this->unresolvedDependencies;
    }
    
    
    public static function createFromArray(string $objectName, array $data)
    {
        $definition = new static($objectName);
        $definition->setNamespace($data[SchemaKey::NAMESPACE]);
        $definition->setDescription($data[SchemaKey::DESCRIPTION]);
        $definition->setExtends($data[SchemaKey::EXTENDS]);
        $definition->setImplements($data[SchemaKey::IMPLEMENTS]);
        $definition->setTraits($data[SchemaKey::TRAITS]);
        $definition->setAnnotations($data[SchemaKey::ANNOTATIONS]);
        $definition->setAbstract($data[SchemaKey::ABSTRACT]);
        $definition->setFinal($data[SchemaKey::FINAL]);
        $definition->setType($data[SchemaKey::TYPE]);

        // Use
        foreach ($data[SchemaKey::USE] as $use) {
            $definition->addUse(
                new UseDefinition($use[SchemaKey::CLASS_NAME], $use[SchemaKey::AS])
            );
        }

        // Properties
        foreach ($data[SchemaKey::PROPERTIES] as $propertyName => $property) {
            $definition->addProperty(
                PropertyDefinition::createFromArray($propertyName, $property)
            );
        }

        // Methods
        foreach ($data[SchemaKey::METHODS] as $methodName => $method) {
            $definition->addMethod(
                MethodDefinition::createFromArray($methodName, $method)
            );
        }

        return $definition;
    }
}
