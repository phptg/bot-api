<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFileTo;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Phptg\BotApi\Transport\PsrTransport;
use Phptg\BotApi\Transport\SaveFileException;
use Yiisoft\Files\FileHelper;

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringEqualsFile;

final class PsrTransportDownloadFileToTest extends TestCase
{
    private const RUNTIME_PATH = __DIR__ . '/runtime';

    protected function setUp(): void
    {
        FileHelper::removeDirectory(self::RUNTIME_PATH);
        FileHelper::ensureDirectory(self::RUNTIME_PATH);
    }

    public function testBase(): void
    {
        $streamFactory = new StreamFactory();
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(200, body: $streamFactory->createStream('hello-content')));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://example.com/test.txt')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            $streamFactory,
        );

        $filePath = self::RUNTIME_PATH . '/file.txt';

        $transport->downloadFileTo('https://example.com/test.txt', $filePath);

        assertFileExists($filePath);
        assertStringEqualsFile($filePath, 'hello-content');
    }

    public function testExceptionOnFilePutContents(): void
    {
        $filePath = self::RUNTIME_PATH . '/exception-file-put-contents.txt';
        touch($filePath);
        chmod($filePath, 0444);
        assertFileExists($filePath);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn(new Response(200));

        $transport = new PsrTransport(
            $client,
            $this->createMock(RequestFactoryInterface::class),
            new StreamFactory(),
        );

        $this->expectException(SaveFileException::class);
        $this->expectExceptionMessage('Failed to open stream: Permission denied');
        $transport->downloadFileTo('https://example.com/test.txt', $filePath);
    }
}
