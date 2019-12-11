<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * AbstractDefinition
 */
abstract class AbstractDefinitionSchema implements ConfigurationInterface
{
    public static function create(): NodeDefinition
    {
        $def = new static();
        return $def->getConfigTreeBuilder();
    }
}
