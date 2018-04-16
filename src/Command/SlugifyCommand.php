<?php

namespace App\Command;

use Cocur\Slugify\SlugifyInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of SlugifyCommand
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class SlugifyCommand extends Command
{
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
        parent::__construct();
    }

    protected function configure ()
    {
        $this
            ->setName('app:slugify')
            ->setDescription("Converts a string into a slug.")
            ->addArgument("string", InputArgument::REQUIRED, "String to convert")
            ->addOption("ruleset", "r", InputOption::VALUE_REQUIRED, "Ruleset for conversion");
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $string = $input->getArgument('string');

        $output->writeln($this->slugify->slugify($string));
    }
}
