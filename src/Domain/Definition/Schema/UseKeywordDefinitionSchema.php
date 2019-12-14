<?php


namespace Morebec\ObjectGenerator\Domain\Definition\Schema;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use function is_array;

class UseKeywordDefinitionSchema extends AbstractDefinitionSchema
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::USE);


        $node = $treeBuilder->getRootNode();

        $node
            ->beforeNormalization()
                ->ifTrue(static function($v) {
                    return !is_array($v);
                })
                ->then(static function($v){
                    return [[SchemaKey::CLASS_NAME => $v, SchemaKey::AS => null]];
                })
                ->end()
            ->arrayPrototype()
                ->beforeNormalization()
                    ->ifTrue(static function($v) {
                        return !is_array($v);
                    })
                ->then(static function($v){
                    return [SchemaKey::CLASS_NAME => $v, SchemaKey::AS => null];
                })
                ->end()
                ->children()
                    ->scalarNode(SchemaKey::CLASS_NAME)->end()
                    ->scalarNode(SchemaKey::AS)->defaultNull()->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}