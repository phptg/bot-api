<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class InputFileCollectorTest extends TestCase
{
    public function testBase(): void
    {
        $file1 = new InputFile(null);
        $file2 = new InputFile(null);

        $collector = new FileCollector();
        $collector->add($file1);
        $collector->add($file2);

        assertSame(
            [
                'file0' => $file1,
                'file1' => $file2,
            ],
            $collector->get(),
        );
    }
    public function testCustomParameters(): void
    {
        $file1 = new InputFile(null);
        $file2 = new InputFile(null);

        $collector = new FileCollector('test', 23);
        $collector->add($file1);
        $collector->add($file2);

        assertSame(
            [
                'test23' => $file1,
                'test24' => $file2,
            ],
            $collector->get(),
        );
    }
}
