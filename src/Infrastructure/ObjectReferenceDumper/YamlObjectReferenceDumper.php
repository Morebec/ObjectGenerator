<?php


namespace Morebec\ObjectGenerator\Infrastructure\ObjectReferenceDumper;

use Morebec\ObjectGenerator\Domain\Definition\Schema\ObjectDefinitionSchema;
use Morebec\ObjectGenerator\Domain\ObjectReferenceDumper\ObjectReferenceDumperInterface;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

/**
 * Object Reference dumper fpr Yaml
 */
class YamlObjectReferenceDumper implements ObjectReferenceDumperInterface
{
    /**
     * @var YamlReferenceDumper
     */
    private $dumper;

    public function __construct()
    {
        $this->dumper = new YamlReferenceDumper();
    }

    /**
     * @inheritDoc
     */
    public function dump(ObjectDefinitionSchema $schema): string
    {
        return $this->dumper->dump($schema);
    }
}