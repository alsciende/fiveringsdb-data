<?php

namespace App\Command;

use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\ImportingService;
use Alsciende\SerializerBundle\Service\MergingService;
use Alsciende\SerializerBundle\Service\ScanningService;
use Doctrine\ORM\EntityManagerInterface;
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
    /** @var ScanningService $scanningService */
    private $scanningService;

    /** @var ImportingService $importer */
    private $importer;

    /** @var MergingService $merging */
    private $merging;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ValidatorInterface $validator */
    private $validator;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var string $jsonDataPath */
    private $jsonDataPath;

    public function __construct (
        $name = null,
        ScanningService $scanningService,
        ImportingService $importer,
        MergingService $merging,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        parent::__construct($name);
        $this->scanningService = $scanningService;
        $this->importer = $importer;
        $this->merging = $merging;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->logger = $logger;
        $this->jsonDataPath = __DIR__ . '/../../json';

        $this->importer->setLogger($logger);
        $this->merging->setLogger($logger);
    }

    protected function configure ()
    {
        $this
            ->setName('app:data:import')
            ->setDescription("Import data from JSON files to the database");
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $sources = $this->scanningService->findSources();

        foreach($sources as $source) {
            $this->import($source);
        }
    }

    private function import(Source $source)
    {
        $this->entityManager->getRepository($source->getClassName())->findAll();

        $fragments = $this->importer->importSource($source, $this->jsonDataPath);

        foreach ($fragments as $fragment) {
            $errors = $this->validator->validate($fragment->getEntity());
            if (count($errors) > 0) {
                /** @var ConstraintViolationInterface $error */
                foreach ($errors as $error) {
                    $this->logger->error('Validation error', [
                        "path" => $fragment->getBlock()->getPath(),
                        "data" => $fragment->getData(),
                        "error" => $error->getMessage(),
                    ]);
                }
                throw new \Exception((string) $errors);
            }

            dump($fragment->getEntity());
            $this->merging->merge($fragment);
        }

        $this->entityManager->flush();
    }
}
