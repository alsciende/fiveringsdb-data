<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GenerateJsonTraitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:generate:trait')
            ->setDescription("Add a trait to the Label json file");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $id = $helper->ask($input, $output, new Question('Id: '));
        $value = $helper->ask($input, $output, new Question('Label: '));

        $filename = './json/Label/en.json';
        $labels = json_decode(file_get_contents($filename), true);
        $labels[] = [
            'id'    => 'trait.' . $id,
            'value' => $value,
        ];

        uasort($labels, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });

        file_put_contents($filename, json_encode(array_values($labels), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
