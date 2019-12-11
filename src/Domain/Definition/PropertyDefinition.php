<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

use Morebec\ObjectGenerator\Domain\Definition\Schema\SchemaKey;

class PropertyDefinition
{
    /**
     * @var string
     */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $visibility;

    /** @var string */
    private $static;

    /** @var string[] */
    private $annotations;
    
    /**
     * @var MethodDefinition|null
     */
    private $accessor;
    
    /**
     * @var MethodDefinition|null
     */
    private $mutator;
    
    /**
     * Indicates if the property should be constant.
     * @var bool
     */
    private $constant;
    
    /**
     * The type to use for this property
     * @var VariableType
     */
    private $type;
    
    /**
     * If value is null it means that no value should be defined for
     * the property. (PHP initializes all properties at null if nothing is
     * provided anyway)
     * @var string
     */
    private $value;

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
     * Returns the value of 'static'
     * @return string
     */
    public function getStatic(): string
    {
        return $this->static;
    }

    /**
     * Returns the value of 'annotations'
     * @return string[]
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

    public function setStatic(string $static): void
    {
        $this->static = $static;
    }

    public function setAnnotations(array $annotations): void
    {
        $this->annotations = $annotations;
    }
    public function getConstant(): bool
    {
        return $this->constant;
    }

    public function setConstant(bool $constant): void
    {
        $this->constant = $constant;
    }
    
    public function getType(): VariableType
    {
        return $this->type;
    }

    public function setType(VariableType $type): void
    {
        $this->type = $type;
    }
        
    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
    
    public function getAccessor(): ?MethodDefinition
    {
        return $this->accessor;
    }

    public function getMutator(): ?MethodDefinition
    {
        return $this->mutator;
    }

    public function setAccessor(?MethodDefinition $accessor): void
    {
        $this->accessor = $accessor;
    }

    public function setMutator(?MethodDefinition $mutator): void
    {
        $this->mutator = $mutator;
    }
    
    /**
     * Builds a new property instance from an array
     * @param string $propertyName name of the property to build
     * @param array $data data
     * @return \self
     */
    public static function createFromArray(string $propertyName, array $data): self
    {
        $propertyDefinition = new static($propertyName);
        $propertyDefinition->setDescription($data[SchemaKey::DESCRIPTION]);
        $propertyDefinition->setVisibility($data[SchemaKey::VISIBILITY]);
        $propertyDefinition->setStatic($data[SchemaKey::STATIC]);
        $propertyDefinition->setAnnotations($data[SchemaKey::ANNOTATIONS]);
        $propertyDefinition->setConstant($data[SchemaKey::CONSTANT]);
        $propertyDefinition->setValue($data[SchemaKey::VALUE]);
        $propertyDefinition->setType(VariableType::fromString($data[SchemaKey::TYPE]));
        
        
        // Accessor
        if (array_key_exists(SchemaKey::ACCESSOR, $data) && $data[SchemaKey::ACCESSOR]) {
            $accessorName = $data[SchemaKey::ACCESSOR][SchemaKey::NAME];
            if (!$accessorName) {
                $accessorName = "get" . ucfirst($propertyName);
            }

            $data[SchemaKey::ACCESSOR][SchemaKey::NAME] = $accessorName;
            
            // Description
            $data[SchemaKey::ACCESSOR][SchemaKey::DESCRIPTION] = "Returns the value of $propertyName";
                
            // Add Parameters
            $data[SchemaKey::ACCESSOR][SchemaKey::PARAMETERS] = [];
            
            // Add code
            $data[SchemaKey::ACCESSOR][SchemaKey::CODE] = sprintf('return $this->%s;', $propertyName);
            
            // Add a default return type for the accessor
            $data[SchemaKey::ACCESSOR][SchemaKey::RETURN] = [
                    SchemaKey::TYPE => $propertyDefinition->getType()->getRawType(),
                    SchemaKey::DESCRIPTION => "Value of $propertyName"
            ];
    
            $propertyDefinition->setAccessor(
                MethodDefinition::createFromArray(
                    $accessorName,
                    $data[SchemaKey::ACCESSOR]
                )
            );
        }
        
        // Mutator
        if (array_key_exists(SchemaKey::MUTATOR, $data) && $data[SchemaKey::MUTATOR]) {
            $mutatorName = $data[SchemaKey::MUTATOR][SchemaKey::NAME];
            if (!$mutatorName) {
                $mutatorName = "set" . ucfirst($propertyName);
            }
            $data[SchemaKey::MUTATOR][SchemaKey::NAME] = $mutatorName;

            // Description
            $data[SchemaKey::MUTATOR][SchemaKey::DESCRIPTION] = "Sets the value of $propertyName";
            
            // Add parameters
            $data[SchemaKey::MUTATOR][SchemaKey::PARAMETERS] = [
               $propertyName => [
                   SchemaKey::TYPE => $propertyDefinition->getType()->getRawType(),
                   SchemaKey::INITIALIZE => true,
                   SchemaKey::DESCRIPTION => "new value of $propertyName",
                   SchemaKey::DEFAULT => VariableType::UNDEFINED,
                   SchemaKey::ANNOTATIONS => []
               ]
            ];
            
            // Add a default return type for the accessor
            $data[SchemaKey::MUTATOR][SchemaKey::RETURN] = [
                    SchemaKey::TYPE => VariableType::UNDEFINED,
                    SchemaKey::DESCRIPTION => ""
            ];
            
            // Add
            $propertyDefinition->setMutator(
                MethodDefinition::createFromArray(
                    $mutatorName,
                    $data[SchemaKey::MUTATOR]
                )
            );
        }

        return $propertyDefinition;
    }
}
