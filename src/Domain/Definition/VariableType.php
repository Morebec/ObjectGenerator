<?php

namespace Morebec\ObjectGenerator\Domain\Definition;

/**
 * VariableType
 */
class VariableType
{
    /** Value used to differentiate between null and undefined **/
    public const UNDEFINED = '__undefined__';
    
    public const MIXED = 'mixed';
    
    public const ARRAY = 'array';
    
    public const NULL = 'null';
    
    public const STRING = 'string';
    
    public const INT = 'int';
    
    public const FLOAT = 'float';
    
    public const BOOL = 'bool';
    
    public const OBJECT = 'object';
    
    public const VOID = 'void';
    
    public const PRIMITIVES = [
        self::STRING,
        self::ARRAY,
        self::INT,
        self::FLOAT,
        self::BOOL,
        self::OBJECT,
    ];
    
    
    /**
     * @var string
     */
    private $rawType;

    private function __construct(string $rawType)
    {
        $this->rawType = $rawType;
    }

    /**
     * Indicates if the type is nullable
     * @return bool
     */
    public function isNullable(): bool
    {
        if ($this->isMixed()) {
            return true;
        }

        // Parse type and find if we have null
        $types = $this->parseRawType();
        foreach ($types as $t) {
            if ($t === self::NULL) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Indicates if the type is mixed or not
     * @return bool true if mixed, otherwise false
     */
    public function isMixed(): bool
    {
        if (in_array($this->rawType, ['', VariableType::MIXED])) {
            return true;
        }
        
        $pieces = $this->parseRawType();

        // non null types
        $types = array_filter($pieces, static function ($p) {
            return $p !== self::NULL;
        });

        // More than one type
        if (count($types) > 1) {
            return true;
        }
        
        return false;
    }
    
    public function isArray(): bool
    {
        if ($this->isMixed()) {
            return false;
        }
        
        // if type ends with []
        // return only the type without '[]'
        $sanitizedType = str_replace('[]', '', $this->rawType);
        if ($this->rawType !== $sanitizedType) {
            return true;
        }
        
        return false;
    }
    
    public function isUndefined()
    {
        return $this->getBaseType() === self::UNDEFINED;
    }
    
    /**
     * Returns the string representation to use
     * in doc blocks
     * @return string
     */
    public function getDocBlockType(): string
    {
        if (in_array($this->rawType, ['', VariableType::UNDEFINED])) {
            return '';
        }

        return $this->rawType;
    }
    
    /**
     * Returns the string representation of the base type
     * to use in code
     * e.g.:
     * int|null => int
     * int|string => mixed
     * string[] => array
     * '' => VariableType::UNDEFINED
     * @return string|null
     */
    public function getBaseType(): ?string
    {
        if (in_array($this->rawType, ['', VariableType::UNDEFINED])) {
            return self::VOID;
        }
        
        // More than one type
        if ($this->isMixed()) {
            return self::MIXED;
        }
        
        if ($this->isArray()) {
            return self::ARRAY;
        }
        
        // At this point we should have only a single type
        // after filtering out null
        $types = array_filter($this->parseRawType(), static function ($p) {
            return $p !== self::NULL;
        });

        // We are only having a single piece
        return $types[0];
    }

    /**
     * Parse the raw type and returns all the detected type pieces
     * e.g: int|null => ['int', 'null']
     *      string   => ['string']
     *      bool|string|float|Custom|null => ['bool', 'string', 'float', 'Custom', 'null']
     * @return array
     */
    private function parseRawType(): array
    {
        return explode('|', $this->rawType);
    }
    
    /**
     * Creates a type instance from a raw string
     * of the form  'bool|string|float|Custom|null'
     * @param string $t
     * @return \static
     */
    public static function fromString(string $t)
    {
        return new static($t);
    }

    public function getRawType(): string
    {
        return $this->rawType;
    }
}
