<?php

namespace Morebec\ObjectGenerator\Domain;

use Exception;
use Morebec\ValueObjects\File\Directory;
use Morebec\ValueObjects\File\File;
use Symfony\Component\Finder\Finder;

/**
 * DependencyResolver
 */
class DependencyResolver
{
    public function getDeclaredClasses(): array
    {
        $config = $this->findComposerConfig();
        $this->loadComposerDeclaredClasses($config);
        $this->loadPsr4DeclaredClasses($config);
        
        $classes = array_merge(
            get_declared_classes(),
            get_declared_interfaces(),
            get_declared_traits()
        );
        
        // Note array merge already makes an array_unique call
        return $classes;
    }
    
    public function loadPsr4DeclaredClasses(File $composerConfig)
    {
        $data = json_decode($composerConfig->getContent(), true);
        $psr4Paths = [];
        foreach ($data['autoload']['psr-4'] as $path) {
            $psr4Paths[] = $path;
        }
                
        // load all php files in paths
        $finder = new Finder();
        $files = $finder
                ->ignoreUnreadableDirs()
                ->in($psr4Paths)
                ->files()
                ->followLinks()
                ->name('*.php')
        ;
        
        $files = array_keys(iterator_to_array($files->getIterator()));
        foreach ($files as $f) {
            require_once $f;
        }
    }

    /**
     * Starting at cwd and going up, tries to find
     * the composer.json of the current project
     * @return File|null
     * @throws Exception
     */
    public function findComposerConfig(): ?File
    {
        $currentDir = Directory::fromStringPath(getcwd());
        $composerConfig = null;
        
        while (!$composerConfig) {
            // find composer.json in current dir
            $file = File::fromStringPath(
                $currentDir . DIRECTORY_SEPARATOR . "composer.json"
            );
            if ($file->exists()) {
                return $file;
            }
            
            $parent = $currentDir->getDirectory();
            // Are we up at maximum ?
            if ($parent->isEqualTo($currentDir)) {
                break;
            }
            $currentDir = $parent;
        }
        
        return null;
    }
    
    /**
     * Loads composer's ComposerAutoloaderInit class and returns
     * the declared composer classes
     * @param File $composerConfig
     * @return array
     * @throws \Exception
     */
    public function loadComposerDeclaredClasses(File $composerConfig): array
    {
        $composerAutoloader = $composerConfig->getDirectory() .
                                DIRECTORY_SEPARATOR . 'vendor' .
                                DIRECTORY_SEPARATOR . 'autoload.php';
        
        if (!file_exists($composerAutoloader)) {
            throw new Exception('Composer dependencies not installed. Please run composer install');
        }

        require $composerAutoloader;

        $res = get_declared_classes();
        
        $autoloaderClassName = null;
        foreach ($res as $c) {
            if (strpos($c, 'ComposerAutoloaderInit') === 0) {
                $autoloaderClassName = $c;
            }
        }
        
        if (!$autoloaderClassName) {
            throw new Exception('Composer Autoloader not found');
        }
        
        $classes = [];
        $classLoader = $autoloaderClassName::getLoader();
        foreach ($classLoader->getClassMap() as $path) {
            $classLoader->loadClass($path);
        }
        
        return $classes;
    }
}
