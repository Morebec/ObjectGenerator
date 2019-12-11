<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ObjectDefinitionSchema
 */
class ObjectDefinitionSchema implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $typeName;

    public function __construct(string $typeName)
    {
        $this->typeName = $typeName;
    }
    
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->typeName);

        $root = $treeBuilder->getRootNode();
        $root
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('namespace')->defaultValue(null)->end()
                ->append(FinalKeywordDefinitionSchema::create())
                ->append(AbstractKeywordDefinitionSchema::create())
                ->enumNode(SchemaKey::TYPE)
                    ->values(['class', 'interface', 'trait'])
                    ->isRequired()
                ->end()
                ->scalarNode(SchemaKey::DESCRIPTION)
                    ->defaultValue('')
                ->end()
                ->scalarNode(SchemaKey::EXTENDS)->defaultValue(null)->end()
                ->arrayNode(SchemaKey::IMPLEMENTS)
                    ->beforeNormalization()->castToArray()->end()
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode(SchemaKey::TRAITS)
                    ->beforeNormalization()->castToArray()->end()
                    ->scalarPrototype()->end()
                ->end()
                ->append(AnnotationsDefinitionSchema::create())
                ->append(PropertiesDefinitionSchema::create())
                ->append(MethodsDefinitionSchema::create())
                ->arrayNode(SchemaKey::USE)
                    ->beforeNormalization()->castToArray()->end()
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
