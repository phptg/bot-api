<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\TelegramBotApi\DownloadFileCopiesStream;

use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Tests\Support\TransportMock;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

final class DownloadFileCopiesStreamTest extends TestCase
{
    private const FILE = __DIR__ . '/test.txt';

    public function testBase(): void
    {
        $transport = new TransportMock(
            downloadFileResource: fopen(self::FILE, 'rb'),
        );

        $api = new TelegramBotApi('xyz', transport: $transport);

        $result = $api->downloadFile('test.jpg');

        assertSame(
            file_get_contents(self::FILE),
            $result->getBody(),
        );
        assertSame('php://temp', stream_get_meta_data($result->getStream())['uri']);
    }
}
