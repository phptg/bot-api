<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFile;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\Tests\Support\RequestException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;
use Phptg\BotApi\Transport\DownloadFileException;
use Phptg\BotApi\Transport\PsrTransport;
use Yiisoft\Test\Support\HttpMessage\StringStream;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class DownloadFileTest extends TestCase
{
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

        $stream = fopen('php://temp', 'r+b');
        $transport->downloadFile('https://example.com/test.txt', $stream);
        rewind($stream);

        assertSame('hello-content', stream_get_contents($stream));
    }

    public function testSendRequestException(): void
    {
        $httpRequest = new Request();
        $requestException = new RequestException('test', $httpRequest);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->method('sendRequest')
            ->with($httpRequest)
            ->willThrowException($requestException);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $stream = fopen('php://temp', 'r+b');

        $exception = null;
        try {
            $transport->downloadFile('https://example.com/test.txt', $stream);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($requestException, $exception->getPrevious());
    }

    public function testRewind(): void
    {
        $streamFactory = new StreamFactory();
        $httpRequest = new Request();

        $httpResponse = new Response(200, body: $streamFactory->createStream('hello-content'));
        $httpResponse->getBody()->getContents();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn($httpResponse);

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

        $stream = fopen('php://temp', 'r+b');
        $transport->downloadFile('https://example.com/test.txt', $stream);
        rewind($stream);

        assertSame('hello-content', stream_get_contents($stream));
    }

    public function testWritesBodyContentWhenDetachReturnsNull(): void
    {
        $httpRequest = new Request();

        $body = $this->createMock(StreamInterface::class);
        $body->method('isSeekable')->willReturn(false);
        $body->method('detach')->willReturn(null);
        $body->method('__toString')->willReturn('file-content');

        $response = new Response(body: $body);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->with($httpRequest)->willReturn($response);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')
            ->with('GET', 'https://example.com/file')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $stream = fopen('php://memory', 'w+');
        $transport->downloadFile('https://example.com/file', $stream);
        rewind($stream);

        assertSame('file-content', stream_get_contents($stream));
        fclose($stream);
    }

    public function testThrowsExceptionOnStreamCopyWarning(): void
    {
        $httpRequest = new Request();

        $streamFactory = new StreamFactory();
        $bodyStream = $streamFactory->createStream('content');
        $response = new Response(body: $bodyStream);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->with($httpRequest)->willReturn($response);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')
            ->with('GET', 'https://example.com/file')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            $streamFactory,
        );

        stream_wrapper_register('warnwrite', WarnWriteStreamWrapper::class);
        try {
            $stream = fopen('warnwrite://test', 'w');

            $this->expectException(DownloadFileException::class);
            $this->expectExceptionMessage('Custom write error');
            $transport->downloadFile('https://example.com/file', $stream);
        } finally {
            stream_wrapper_unregister('warnwrite');
        }
    }

    public function testThrowsExceptionWhenFwriteFails(): void
    {
        $httpRequest = new Request();
        $response = new Response(body: new StringStream('content', seekable: false));

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')
            ->with($httpRequest)
            ->willReturn($response);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')
            ->with('GET', 'https://example.com/file')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        stream_wrapper_register('failwrite', FailWriteStreamWrapper::class);
        try {
            $stream = fopen('failwrite://test', 'w');

            $this->expectException(DownloadFileException::class);
            $this->expectExceptionMessage('Failed to write file content to stream.');
            $transport->downloadFile('https://example.com/file', $stream);
        } finally {
            stream_wrapper_unregister('failwrite');
        }
    }
}
