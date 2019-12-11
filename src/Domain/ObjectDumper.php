<?php

namespace Morebec\ObjectGenerator\Domain;

use Morebec\ObjectGenerator\Domain\Definition\ObjectDefinition;
use Nette\PhpGenerator\ClassType;

/**
 * Dumps a constructed object from a definition
 * to a string
 */
class ObjectDumper
{
    public function dump(
        ObjectDefinition $definition,
        ClassType $type
    ): string {
        $classCode = (string)$type;
        
        $namespace = $definition->getNamespace();

        if ($namespace) {
            $namespace = "namespace $namespace;" . PHP_EOL . PHP_EOL;
        }
        
        $use = join(PHP_EOL, array_map(static function ($n) {
            return "use $n;";
        }, $definition->getUse()));
        if ($use) {
            $use = $use . PHP_EOL . PHP_EOL;
        }
        
        $code = "<?php" . PHP_EOL .
                PHP_EOL .
                "$namespace" .
                "$use" .
                $classCode .
                PHP_EOL;
        
        // Replace tabs by 4 spaces
        return str_replace("\t", str_repeat(' ', 4), $code);
    }

    public static function dumpObjectGenerationResult(
        ObjectGenerationResult $result
    ): string {
        return self::dumpObject($result->getDefinition(), $result->getObject());
    }
    
    public static function dumpObject(
        ObjectDefinition $definition,
        ClassType $type
    ): string {
        $dumper = new static();
        return $dumper->dump($definition, $type);
    }
}
