<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * FinalKeywordDefinitionSchema
 */
class FinalKeywordDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::FINAL, 'boolean');
        $node = $treeBuilder->getRootNode();
        $node->defaultFalse()->end();
        
        return $node;
    }
}
