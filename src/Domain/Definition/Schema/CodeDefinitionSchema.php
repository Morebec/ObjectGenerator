<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * CodeDefinition
 */
class CodeDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::CODE, 'scalar');
        $node = $treeBuilder->getRootNode();
        $node
                ->info('You can specify some PHP code to be injected here.')
                ->defaultValue(null)
        ->end()
        ;
        
        return $node;
    }
}
