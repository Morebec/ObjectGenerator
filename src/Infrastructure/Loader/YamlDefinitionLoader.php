<?php

namespace Morebec\ObjectGenerator\Infrastructure\Loader;

use Morebec\ObjectGenerator\Domain\Exception\FileNotFoundException;
use Morebec\ObjectGenerator\Domain\Exception\InvalidDefinitionException;
use Morebec\ObjectGenerator\Domain\Loader\DefinitionLoaderInterface;
use Morebec\ValueObjects\File\File;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * YamlDefinitionLoader
 */
class YamlDefinitionLoader implements DefinitionLoaderInterface
{
    public function loadDefinitionFile(File $file): array
    {
        if (!$file->exists()) {
            throw new FileNotFoundException($file);
        }
        
        try {
            $data = Yaml::parse($file->getContent());
        } catch (ParseException $ex) {
            throw new InvalidDefinitionException($file, $ex->getMessage());
        }

        return $data;
    }
}
