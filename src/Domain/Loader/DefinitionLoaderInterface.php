<?php

namespace Morebec\ObjectGenerator\Domain\Loader;

use Morebec\ObjectGenerator\Domain\Exception\FileNotFoundException;
use Morebec\ValueObjects\File\File;

/**
 * A Definition Loader is responsible for loading definition files
 * in a specific format and to return their content as an array
 * that can be used by the definition classes
 */
interface DefinitionLoaderInterface
{
    /**
     * Loads a definition from a file
     * @param File $file
     * @return array
     * @throws FileNotFoundException
     */
    public function loadDefinitionFile(File $file): array;
}
