<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * AnnotationsDefinition
 */
class AnnotationsDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::ANNOTATIONS);
        $node = $treeBuilder->getRootNode();
        $node
            ->beforeNormalization()->castToArray()->end()
            ->scalarPrototype()->end()
            ->end()
        ;

        return $node;
    }
}
