<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

/**
 * ReturnTypeDefinition
 */
class ReturnTypeDefinition
{
    public const VOID = 'void';
    
    /**
     * @var string
     */
    private $description;

    /**
     * The type to use for this property, or null if no type should be used
     * @var VariableType
     */
    private $type;

    public function __construct(VariableType $type, string $description)
    {
        $this->type = $type;
        $this->description = $description;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the type
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
     * @return string|null
     */
    public function getBaseType(): ?string
    {
        return $this->type->getBaseType();
    }
}
