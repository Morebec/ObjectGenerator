<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * ParameterDefinition
 */
class ParametersDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::PARAMETERS);
        
        $node = $treeBuilder->getRootNode();
        $node
            ->useAttributeAsKey(SchemaKey::NAME)
            ->arrayPrototype()
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode(SchemaKey::TYPE)->defaultValue(VariableType::UNDEFINED)->end()
                    ->scalarNode(SchemaKey::DEFAULT)->defaultValue(VariableType::UNDEFINED)->end()
                    ->scalarNode(SchemaKey::DESCRIPTION)
                        ->defaultValue('')
                    ->end()
                    ->append(AnnotationsDefinitionSchema::create())
                    ->booleanNode(SchemaKey::INITIALIZE)
                        ->info('This option is mostly useful for __construct. 
It will initialize the parameter to a property of the same name. (E.g: $this->property = $parameter)')
                        ->defaultFalse()
                    ->end()
                ->end()
            ->end()
        ;
        return $node;
    }
}
