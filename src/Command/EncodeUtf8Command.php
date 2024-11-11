<?php

namespace App\Command;

use App\Model\Clan;
use App\Model\Side;
use App\Model\Type;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\String\UnicodeString;

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
            $data['text'] = $data['text'] ? str_replace("\n", "<br>", $data['text']) : null;
            foreach ($data as $k => $v) {
                $key = new UnicodeString($k);
                $snakeKey = $key->snake()->toString();
                if ($k !== $snakeKey) {
                    $data[$snakeKey] = $v;
                    unset($data[$k]);
                }
            }
            if (isset($data['allowed_clans']) && is_array($data['allowed_clans']) && (!in_array(count($data['allowed_clans']), [1,7]))) {
                $io->comment($filename);
            } else {
                if ($this->isRestrictedClan($data)) {
                    $data['allowed_clans'] = [ $data['clan'] ];
                } else {
                    $data['allowed_clans'] = [ '*' ];
                }
            }
            ksort($data);
            $this->putFileJsonContent($filename, $data);
        }

        $finder->files()->in('./json/PackCard/');

        foreach ($finder as $file) {
            $filename = $file->getRealPath();
            $data = $this->getFileJsonContent($filename);
            $this->putFileJsonContent($filename, $data);
        }

        return Command::SUCCESS;
    }

    private function isRestrictedClan(array $data): bool
    {
        if ($data['clan'] === Clan::NEUTRAL->value) {
            return false;
        } else {
            switch ($data['side']) {
                case Side::PROVINCE->value:
                case Side::DYNASTY->value:
                case Side::ROLE->value:
                    return true;
                    break;
                case Side::CONFLICT->value:
                    if (is_int($data['influence_cost'])) {
                        return false;
                    } else {
                        return true;
                    }
                    break;
            }
        }
    }
}
