<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * MethodConfiguration
 */
class MethodsDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::METHODS);
        
        
        $node = $treeBuilder->getRootNode();

        $node
            ->arrayPrototype()
                ->children()
                    ->scalarNode(SchemaKey::DESCRIPTION)
                        ->defaultValue('')
                    ->end()
                    ->append(VisibilityKeywordDefinitionSchema::create())
                    ->append(AbstractKeywordDefinitionSchema::create())
                    ->append(FinalKeywordDefinitionSchema::create())
                    ->append(StaticKeywordDefinitionSchema::create())
                    ->append(AnnotationsDefinitionSchema::create())
                    ->append(CodeDefinitionSchema::create())
                    ->append(ParametersDefinitionSchema::create())
                    ->arrayNode(SchemaKey::RETURN)
                        ->info("Return type definition goes here. If you don't want to provide a return type, simply ommit this parameter")
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode(SchemaKey::TYPE)->defaultValue(VariableType::UNDEFINED)->end()
                            ->scalarNode(SchemaKey::DESCRIPTION)->defaultValue('')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()

        ;

        return $node;
    }
}
