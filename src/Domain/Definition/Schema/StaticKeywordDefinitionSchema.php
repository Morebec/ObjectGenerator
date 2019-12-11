<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * StaticDefinition
 */
class StaticKeywordDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::STATIC, 'boolean');
        $node = $treeBuilder->getRootNode();
        $node->defaultFalse()->end();
        
        return $node;
    }
}
