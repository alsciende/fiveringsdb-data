<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'app:encode:utf8',
    description: 'Add a short description for your command',
)]
class EncodeUtf8Command extends Command
{
    use JsonTrait;

    public function __construct()
    {
        $this->fs = new Filesystem();
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $finder = new Finder();
        $finder->files()->in('./json/Card/');

        foreach ($finder as $file) {
            $filename = $file->getRealPath();
            $data = $this->getFileJsonContent($filename);
            $this->putFileJsonContent($filename, $data);
        }

        return Command::SUCCESS;
    }
}
