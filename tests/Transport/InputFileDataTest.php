<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport;

use LogicException;
use Phptg\BotApi\Transport\InputFileData;
use Phptg\BotApi\Type\InputFile;
use PHPUnit\Framework\TestCase;

final class InputFileDataTest extends TestCase
{
    public function testWithoutReader(): void
    {
        $file = new InputFile(null);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('No suitable resource reader found.');
        new InputFileData($file, []);
    }
}
