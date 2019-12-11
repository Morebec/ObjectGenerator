<?php

namespace Morebec\ObjectGenerator\Application\Console\ConsoleCommand;

use Exception;
use Morebec\ObjectGenerator\Application\Shared\Constant;
use Morebec\ObjectGenerator\Application\Shared\Service\ApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * AbstractCommand giving acess to the application service
 */
abstract class AbstractCommand extends Command
{
    public const STATUS_SUCCESS = 0;
    public const STATUS_ERROR = 1;

    /**
     * @var ApplicationService
     */
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
        parent::__construct(null);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $io->title(sprintf("<info>ObjectGenerator v%s</info>", Constant::VERSION));

            $statusCode = $this->exec($input, $output, $io);
            $output->writeln('');
        } catch(Exception $e) {
            $statusCode = self::STATUS_ERROR;
            $io->getErrorStyle()->error($e->getMessage());
        }

        return $statusCode;
    }

    /**
     * Executes the command and returns it status code
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param SymfonyStyle $io
     * @return int
     */
    public abstract function exec(InputInterface $input, OutputInterface $output, SymfonyStyle $io): int;
}