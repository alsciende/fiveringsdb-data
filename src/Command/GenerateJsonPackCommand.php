<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class GenerateJsonPackCommand extends Command
{
    protected function configure ()
    {
        $this
            ->setName('app:generate:pack')
            ->setDescription("Generate json file for a pack")
            ->addArgument('id', InputArgument::REQUIRED, 'Id of the pack')
            ->addArgument('position', InputArgument::REQUIRED)
            ->addArgument('size', InputArgument::REQUIRED)
            ->addArgument('ffgid', InputArgument::OPTIONAL)
        ;
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $args = $input->getArguments();

        $packCards = [];
        $start = $args['size'] * ($args['position'] - 1);
        $relativePosition = 0;
        while ($relativePosition++ < $args['size']) {
            $position = strval($start + $relativePosition);
            $packCards[] = [
                "card_id"     => "",
                "flavor"      => "",
                "illustrator" => "",
                "image_url"   => isset($args['ffgid']) ? "http://lcg-cdn.fantasyflightgames.com/l5r/" . $args['ffgid'] . "_" . $position . ".jpg" : null,
                "position"    => $position,
                "quantity"    => 3,
            ];
        }

        file_put_contents('./json/PackCard/' . $args['id'] . ".json", json_encode($packCards, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
