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

#[AsCommand(
    name: 'app:generate:starter',
    description: 'Generate the starter deck for a Clan',
)]
class GenerateStarterCommand extends Command
{
    use JsonTrait;

    private Filesystem $fs;

    public function __construct()
    {
        $this->fs = new Filesystem();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('clan', InputArgument::REQUIRED, 'Clan name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $clan = $input->getArgument('clan');

        $core = $this->getFileJsonContent('./json/PackCard/core.json');
        foreach ($core as $card) {
            $data = $this->getFileJsonContent("./json/Card/{$card['card_id']}.json");
            if ($data['clan'] === $clan) {
                if ($data['type'] !== 'province') {
                    $io->text($data['id']);
                }
            }
            if ($data['clan'] === 'neutral') {
                if ($data['id'] === 'keeper-initiate' || $data['id'] === 'seeker-initiate') {
                    continue;
                }
                switch ($data['side']) {
                    case 'dynasty':
                    case 'conflict':
                        $io->text($data['id']);
                        break;
                    case 'province':
                    case 'role':
                        break;
                }
            }
        }

        switch($clan) {
            case 'crane':
            case 'dragon':
            case 'phoenix':
            case 'scorpion':
                $io->text('01-fertile-fields');
                $io->text('01-entrenched-position');
                $io->text('01-night-raid');
                $io->text('01-elemental-fury');
                $io->text('01-shameful-display');
                break;
            case 'crab':
            case 'lion':
            case 'unicorn':
                $io->text('01-manicured-garden');
                $io->text('01-ancestral-lands');
                $io->text('01-meditations-on-the-tao');
                $io->text('01-rally-to-the-cause');
                $io->text('01-pilgrimage');
                break;
        }


        return Command::SUCCESS;
    }
}
