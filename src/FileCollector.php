<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\Type\InputFile;

/**
 * @api
 */
final class FileCollector
{
    private int $counter;

    /**
     * @psalm-var array<string,InputFile>
     */
    private array $files = [];

    public function __construct(
        private readonly string $prefix = 'file',
        int $start = 0,
    ) {
        $this->counter = $start;
    }

    public function add(InputFile $file): string
    {
        $key = $this->prefix . $this->counter++;
        $this->files[$key] = $file;
        return $key;
    }

    /**
     * @psalm-return array<string,InputFile>
     */
    public function get(): array
    {
        return $this->files;
    }
}
