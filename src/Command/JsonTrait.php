<?php

namespace App\Command;

use Symfony\Component\Filesystem\Filesystem;

trait JsonTrait
{
    private Filesystem $fs;

    private function putFileJsonContent(string $filename, array $data): void
    {
        $this->fs->dumpFile($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function getFileJsonContent(string $filename): array
    {
        return json_decode($this->fs->readFile($filename), true);
    }
}