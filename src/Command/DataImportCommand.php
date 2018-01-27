<?php

namespace App\Command;

use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\ImportingService;
use Alsciende\SerializerBundle\Service\MergingService;
use Alsciende\SerializerBundle\Service\ScanningService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
