<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * For Abstract Keyword field definition
 */
class AbstractKeywordDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::ABSTRACT, 'boolean');
        $node = $treeBuilder->getRootNode();
        $node->defaultFalse()->end();
        
        return $node;
    }
}
