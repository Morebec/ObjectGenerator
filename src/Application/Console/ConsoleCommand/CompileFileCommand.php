<?php


namespace Morebec\ObjectGenerator\Application\Console\ConsoleCommand;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CompileFileCommand extends AbstractCommand
{
    protected static $defaultName = 'compile:file';

    protected function configure()
    {
        $this->setDescription('Generate a PHP Object file fro a YAML configuration');
        $this->setHelp(
            'This command allows one to generate PHP object files using a YAML configuration format.'
        );

        $this->addArgument(
            'file',
            InputArgument::REQUIRED,
            'Path to the file to generate'
        );

        $this->addOption(
            'out-file',
            'o',
            InputOption::VALUE_OPTIONAL,
            'Output file where the generated object should be sent. If not specified prints to screen.'
        );

        $this->addOption(
            'namespace',
            's',
            InputOption::VALUE_OPTIONAL,
            'Namespace of the object. Overrides the configuration value if any'
        );
    }

    /**
     * @inheritDoc
     */
    public function exec(InputInterface $input, OutputInterface $output, SymfonyStyle $io): int
    {
        // Gather command arguments and options
        $namespace = $input->getOption('namespace');    // Namespace override
        $outFileString = $input->getOption('out-file'); // Target file

        // Generate object
        $file = $input->getArgument('file');
        $result = $this->applicationService->compileFile($file);

        // Override namespace if needed
        if ($namespace) {
            $result->getDefinition()->setNamespace($namespace);
        }

        // Get code
        $io->writeln("Compiling file '$file' ...");
        $t1 = time();
        $code = $this->applicationService->dumpObjectFromObjectGenerationResult($result);

        // Print to relevant place
        if ($outFileString) {
            file_put_contents($outFileString, $code);
        } else {
            echo $code;
        }
        $time = time() - $t1;

        $io->writeln('');
        $io->writeln("<info>Object compiled successfully to '$outFileString' ...</info>");
        $io->writeln('');
        $io->writeln("Time: $time ms");
        $unresolved = $result->getDefinition()->getUnresolvedDependencies();
        $this->displayUnresolvedDependencies($output, $unresolved);

        return 0;
    }

    private function displayUnresolvedDependencies(
        OutputInterface $output,
        array $unresolved
    ): void {
        if (count($unresolved)) {
            $output->writeln(
                "<comment>The following dependencies could not be resolved automatically: </comment>"
            );
            foreach ($unresolved as $dep => $candidates) {
                $candidateString = join("\n\t- ", $candidates);
                if (count($candidates) === 0) {
                    $output->writeln(
                        "<comment>\t<bg=yellow;options=bold>$dep</> has no candidates.</comment>"
                    );
                    continue;
                }
                $output->writeln(
                    "<comment>\t<bg=yellow;options=bold>$dep</> has the following candidates: \n\t- $candidateString</comment>"
                );
            }
        }
    }
}