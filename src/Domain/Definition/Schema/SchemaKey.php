<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

/**
 * List all the schema keys
 * for easier configuration
 */
class SchemaKey
{
    public const NAMESPACE = 'namespace';
    
    public const DESCRIPTION = 'desc';
    
    public const ABSTRACT = 'abstract';
    
    public const STATIC = 'static';
    
    public const VISIBILITY = 'visibility';
    
    public const ANNOTATIONS = 'annotations';
    
    public const USE = 'use';
    
    public const EXTENDS = 'extends';
    
    public const IMPLEMENTS = 'implements';
    
    public const TRAITS = 'traits';
    
    public const CODE = 'code';
    
    public const FINAL = 'final';
    
    public const METHODS = 'methods';
    
    public const PARAMETERS = 'params';
    
    public const PROPERTIES = 'props';
    
    public const RETURN = 'return';
    
    public const INITIALIZE = 'init';
    
    public const DEFAULT = 'default';
    
    public const TYPE = 'type';
    
    public const VALUE = 'value';
    
    public const ACCESSOR = 'accessor';

    public const MUTATOR = 'mutator';
    
    public const CONSTANT = 'constant';
    
    public const NAME = 'name';

    const CLASS_NAME = 'classname';

    const AS = 'as';
}
