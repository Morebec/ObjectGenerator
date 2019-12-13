<?php


namespace Morebec\ObjectGenerator\Application\Console\ConsoleCommand;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpObjectReferenceCommand extends AbstractCommand
{
    protected static $defaultName = 'dump:reference';

    protected function configure()
    {
        $this->setDescription('Dumps the Yaml Object Reference');
        $this->setHelp(
            'This command allows one to dump the Yaml Object Reference to a file'
        );

        $this->addOption(
            'out-file',
            'o',
            InputOption::VALUE_REQUIRED,
            'Output file where the generated object should be sent. If not specified prints to screen.'
        );
    }

    /**
     * @inheritDoc
     */
    public function exec(InputInterface $input, OutputInterface $output, SymfonyStyle $io): int
    {
        $ref = $this->applicationService->dumpReference();

        $io->writeln('Dumping reference ...');
        $outFile = $input->getOption('out-file');

        if(!$outFile) {
            $io->error('Please specify a value for the out file option');
            return self::STATUS_ERROR;
        }

        file_put_contents($outFile, $ref);

        $io->writeln("<info>Reference dumped successfully to '{$outFile}'</info>");

        return parent::STATUS_SUCCESS;
    }
}