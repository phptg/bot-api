<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\TelegramBotApi\DownloadFileStreamCopyError;

use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Tests\Support\TransportMock;
use Phptg\BotApi\Transport\DownloadFileException;
use PHPUnit\Framework\TestCase;

final class DownloadFileStreamCopyErrorTest extends TestCase
{
    public function testBase(): void
    {
        $transport = new TransportMock(
            downloadFileResource: fopen(__DIR__ . '/test.txt', 'wb'),
        );

        $api = new TelegramBotApi('xyz', transport: $transport);

        $this->expectException(DownloadFileException::class);
        $api->downloadFile('test.jpg');
    }
}
