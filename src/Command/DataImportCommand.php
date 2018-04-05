<?php

namespace App\Command;

use Alsciende\SerializerBundle\Service\ImportingService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of DataImportCommand
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DataImportCommand extends Command
{
    /** @var ImportingService $importer */
    private $importer;

    public function __construct (
        $name = null,
        ImportingService $importer,
        LoggerInterface $logger
    )
    {
        parent::__construct($name);
        $this->importer = $importer;
        $this->importer->setLogger($logger);
    }

    protected function configure ()
    {
        $this
            ->setName('app:data:import')
            ->setDescription("Import data from JSON files into entities and validates them");
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->importer->import(__DIR__ . '/../../json', false);
    }
}
