<?php

namespace Morebec\ObjectGenerator\Domain\Exception;

use Morebec\ValueObjects\File\File;

/**
 * FileNotFoundException
 */
class FileNotFoundException extends \Exception
{
    public function __construct(File $file)
    {
        parent::__construct("File '$file' not found");
    }
}
