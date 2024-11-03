<?php

namespace App\Command;

use Curl\Curl;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'app:download:images',
    description: 'Download all card images',
)]
class DownloadImagesCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $finder = new Finder();
        $finder->files()->in('./json/PackCard/');

        $cards = [];

        foreach ($finder as $file) {
            $rows = json_decode($file->getContents(), true);
            foreach ($rows as $card) {
                $cards[] = $card;
            }
        }

        $table = new Table($output);
        $table->setHeaders(['Id', 'URL', 'Image']);

        $curl = new Curl;

        foreach ($cards as $card) {
            $command = sprintf("curl -s -O %s", $card['image_url']);
            $io->note($command);
            passthru($command, $result_code);
            $table->addRow([
                $card['card_id'],
                $card['image_url'],
                $result_code ? '❌' : '✓'
            ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
