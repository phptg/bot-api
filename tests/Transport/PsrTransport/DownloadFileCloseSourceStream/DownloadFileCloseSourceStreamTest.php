<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFileCloseSourceStream;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\Transport\DownloadFileException;
use Phptg\BotApi\Transport\PsrTransport;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamInterface;

use function PHPUnit\Framework\assertSame;

final class DownloadFileCloseSourceStreamTest extends TestCase
{
    protected function setUp(): void
    {
        stream_wrapper_register('error-on-write', ErrorOnWriteStream::class);
        stream_wrapper_register('close-counter', CloseCounterStream::class);
        CloseCounterStream::$closeCount = 0;
    }

    protected function tearDown(): void
    {
        stream_wrapper_unregister('error-on-write');
        stream_wrapper_unregister('close-counter');
    }

    public function testBase(): void
    {
        $httpRequest = new Request();
        $sourceResource = fopen('close-counter://test', 'rb');

        $body = $this->createMock(StreamInterface::class);
        $body->method('isSeekable')->willReturn(false);
        $body->method('detach')->willReturn($sourceResource);
        $response = new Response(body: $body);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->with($httpRequest)->willReturn($response);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')
            ->with('GET', 'https://example.com/test.txt')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $stream = fopen('error-on-write://test', 'wb');

        try {
            $transport->downloadFile('https://example.com/test.txt', $stream);
        } catch (DownloadFileException) {
        }

        assertSame(1, CloseCounterStream::$closeCount);
    }
}
