<?php

namespace Morebec\ObjectGenerator\Domain\Definition\Schema;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * VisibilityDefinition
 */
class VisibilityKeywordDefinitionSchema extends AbstractDefinitionSchema
{
    /**
     * @var string
     */
    private $defaultValue;

    public function __construct(string $defaultValue = 'public')
    {
        ;
        $this->defaultValue = $defaultValue;
    }
    
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SchemaKey::VISIBILITY, 'enum');
        $node = $treeBuilder->getRootNode();
        $node
            ->values(['public', 'protected', 'private'])
            ->defaultValue($this->defaultValue)
            ->end()
        ;

        return $node;
    }
    
    public static function createWithPrivateDefault()
    {
        $def = new static('private');
        return $def->getConfigTreeBuilder();
    }
}
