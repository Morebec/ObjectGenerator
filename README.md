# Object Generator Component
The Object Generator Component, provides functionality to generate PHP objects from Yaml Definitions.
This component is used by [Orkestra](https:/github.com/Morebec/Orkestra).

## Rationale
Because of its syntax, defining classes in PHP requires a lot of typing: 
from namespaces, use declarations, type hints, implements and extends, properties, methods,
constructors, getters and setters, to phpDocBlocks, there's a lot to do. 
After hundreds of classes, your fingers and your motivation can get pretty tired.

We figured, wouldn't it be great to be able to define classes with less verbosity?
Why not use some sort of DSL that could be translated to working PHP classes?
Hence, the Object Generator Component.


## Installation
```json
{
    "repositories": [
        {
            "url": "https://github.com/Morebec/ObjectGenerator.git",
            "type": "git"
        }
    ],
    "require": {
        "morebec/object-generator": "^1.0"
    }
}
```

## Usage
### 1. Create a Yaml Object Definition File
```yaml
# Person.yaml
Person:
    namespace: My\Name\Space
    extends: Human
    desc: This Class represents a Person
    implements: MortalInterface
    type: class

    props:
        fullname:
            desc: Fullname of the person
            type: string
            accessor: true
            
        age:
            desc: Age of the person
            type: int
            accessor: true

    methods:
        __construct:
            desc: Constructs a Person instance
            params:
                fullname:
                    desc: Fullname of the person
                    type: string
                    init: true
                age:
                    desc: Age of the person
                    type: int
                    init: true
                    default: 10
            code: |
                Assertion::notBlank($fullname, 'A person must have a name!');
                Assertion::min($age, 0, 'A person must have a positive age!');
```

### 2. Compile the Object File to PHP

```bash
bin/console compile:file person.yaml
```

### 3. Review your newly created PHP file
```php
<?php

namespace My\Name\Space;

/**
 * This Class represents a Person
 */
class Person extends Human implements MortalInterface
{
    /** @var string Fullname of the person */
    private $fullname;

    /** @var int Age of the person */
    private $age;


    /**
     * Constructs a Person instance
     * @param string $fullname Fullname of the person
     * @param int $age Age of the person
     */
    public function __construct(string $fullname, int $age = 10)
    {
        $this->age = $age;
        $this->fullname = $fullname;
        Assertion::notBlank($fullname, 'A person must have a name!');
        Assertion::min($age, 0, 'A person must have a positive age!');
    }


    /**
     * Returns the value of fullname
     * @return string Value of fullname
     */
    public function getFullname(): string
    {
        return $this->fullname;
    }


    /**
     * Returns the value of age
     * @return int Value of age
     */
    public function getAge(): int
    {
        return $this->age;
    }
}
```


### Library Usage
The Object Generator Component can also be used in projects as a library.
For more information, please read the documentation.

[Documentation](https://github.com/Morebec/ObjectGenerator/tree/docs/user/index.md)


## Full object reference
```yaml
ClassName:
    namespace:            null
    final:                false
    abstract:             false
    type:                 ~ # One of "class"; "interface"; "trait", Required
    desc:                 ''
    extends:              null
    implements:           []
    traits:               []
    annotations:          []
    use:                  []
    
    props:

        # Prototype
        -
            type:                 null
            value:                __undefined__
            desc:                 ''
            annotations:          []
            static:               false
            constant:             false
            visibility:           private # One of "public"; "protected"; "private"

            # You can configure how the getter of this property will be generated here.
            # If you prefer not generating a getter, simply ommit this parameter.
            accessor:

                # You can specify the name of your setter, here.
                # If nothing is specified as a name, it will default to getPropertyName.
                name:                 null
                desc:                 ''
                visibility:           public # One of "public"; "protected"; "private"

                # You can specify some PHP code to be injected here.
                code:                 null
                annotations:          []
                abstract:             false
                static:               false
                final:                false

            # You can configure how the setter of this property will be generated here.
            # If you prefer not generating a setter, simply ommit this parameter.
            mutator:

                # You can specify the name of your setter, here.
                # If nothing is specified as a name, it will default to setPropertyName.
                name:                 null
                desc:                 ''
                visibility:           public # One of "public"; "protected"; "private"

                # You can specify some PHP code to be injected here.
                code:                 null
                annotations:          []
                abstract:             false
                static:               false
                final:                false
    methods:

        # Prototype
        -
            desc:                 ''
            visibility:           public # One of "public"; "protected"; "private"
            abstract:             false
            final:                false
            static:               false
            annotations:          []

            # You can specify some PHP code to be injected here.
            code:                 null
            params:

                # Prototype
                name:
                    type:                 __undefined__
                    default:              __undefined__
                    desc:                 ''
                    annotations:          []

                    # This option is mostly useful for __construct. 
                    # It will initialize the parameter to a property of the same name. (E.g: $this->property = $parameter)
                    init:                 false

            # Return type definition goes here. If you don't want to provide a return type, simply ommit this parameter
            return:
                type:                 __undefined__
                desc:                 ''
```
