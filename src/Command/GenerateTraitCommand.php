<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:generate:trait',
    description: 'Add a trait to the Label json file',
)]
class GenerateTraitCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $id = $helper->ask($input, $output, new Question('Id: '));
        $value = $helper->ask($input, $output, new Question('Label: '));

        $filename = './json/Label/en.json';
        $labels = json_decode(file_get_contents($filename), true);
        $labels[] = [
            'id'    => 'trait.' . $id,
            'value' => $value,
        ];

        uasort($labels, fn($a, $b): int => $a['id'] <=> $b['id']);

        file_put_contents($filename, json_encode(array_values($labels), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return Command::SUCCESS;
    }
}
