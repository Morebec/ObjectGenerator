<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Morebec\ObjectGenerator\Domain\Definition\VariableType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * PropertyDefinition
 */
class PropertiesDefinitionSchema extends AbstractDefinitionSchema
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::PROPERTIES);

        $node = $treeBuilder->getRootNode();
        $node
            ->arrayPrototype()
                ->children()
                    ->scalarNode(SchemaKey::TYPE)->defaultValue(null)->end()
                    ->scalarNode(SchemaKey::VALUE)->defaultValue(VariableType::UNDEFINED)->end()
                    ->scalarNode(SchemaKey::DESCRIPTION)
                        ->defaultValue('')
                    ->end()
                    ->append(AnnotationsDefinitionSchema::create())
                    ->append(StaticKeywordDefinitionSchema::create())
                    ->booleanNode(SchemaKey::CONSTANT)
                        ->defaultFalse()
                    ->end()
                    ->append(VisibilityKeywordDefinitionSchema::createWithPrivateDefault())
                    ->arrayNode(SchemaKey::ACCESSOR)
                        // This is to support bool true or an array
                        ->info('You can configure how the getter of this property will be generated here.
If you prefer not generating a getter, simply ommit this parameter.')
                        ->children()
                            ->scalarNode(SchemaKey::NAME)
                                ->info('You can specify the name of your setter, here.
If nothing is specified as a name, it will default to getPropertyName.')
                                ->defaultNull()->end()
                            ->scalarNode(SchemaKey::DESCRIPTION)->defaultValue('')->end()
                            ->append(VisibilityKeywordDefinitionSchema::create())
                            ->append(CodeDefinitionSchema::create())
                            ->append(AnnotationsDefinitionSchema::create())
                            ->append(AbstractKeywordDefinitionSchema::create())
                            ->append(StaticKeywordDefinitionSchema::create())
                            ->append(FinalKeywordDefinitionSchema::create())
                        ->end()
                    ->end()
                    ->arrayNode(SchemaKey::MUTATOR)
                        // This is to support bool true or an array
                        ->info('You can configure how the setter of this property will be generated here.
If you prefer not generating a setter, simply ommit this parameter.')
                        ->children()
                            ->scalarNode(SchemaKey::NAME)
                                ->info('You can specify the name of your setter, here.
If nothing is specified as a name, it will default to setPropertyName.')
                                ->defaultValue(null)->end()
                            ->scalarNode(SchemaKey::DESCRIPTION)->defaultValue('')->end()
                            ->append(VisibilityKeywordDefinitionSchema::create())
                            ->append(CodeDefinitionSchema::create())
                            ->append(AnnotationsDefinitionSchema::create())
                            ->append(AbstractKeywordDefinitionSchema::create())
                            ->append(StaticKeywordDefinitionSchema::create())
                            ->append(FinalKeywordDefinitionSchema::create())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $node;
    }
}
