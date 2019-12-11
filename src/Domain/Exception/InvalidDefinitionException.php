<?php

namespace Morebec\ObjectGenerator\Domain\Exception;

use Morebec\ValueObjects\File\File;

/**
 * InvalidDefinitionException
 */
class InvalidDefinitionException extends \Exception
{
    public function __construct(File $file, string $reason)
    {
        parent::__construct("Unable to parse definition: $reason in '$file'");
    }
}
