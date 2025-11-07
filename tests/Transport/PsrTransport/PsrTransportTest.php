<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Phptg\BotApi\Transport\PsrTransport;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringContainsStringIgnoringLineEndings;

final class PsrTransportTest extends TestCase
{
    public function testGet(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '//url/getMe?key=value&array=%5B1%2C%22test%22%5D')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->get('//url/getMe?key=value&array=%5B1%2C%22test%22%5D');

        assertSame(201, $response->statusCode);
    }

    public function testPost(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    assertInstanceOf(Request::class, $request);
                    assertSame(
                        [
                            'Content-Length' => ['0'],
                            'Content-Type' => ['application/json; charset=utf-8'],
                        ],
                        $request->getHeaders(),
                    );
                    assertSame('', $request->getBody()->getContents());
                    return true;
                }),
            )
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', '//url/logOut')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->post(
            '//url/logOut',
            '',
            [
                'Content-Length' => '0',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        );

        assertSame(201, $response->statusCode);
    }

    public function testPostWithData(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    assertInstanceOf(Request::class, $request);
                    assertSame(
                        [
                            'Content-Length' => ['29'],
                            'Content-Type' => ['application/json; charset=utf-8'],
                        ],
                        $request->getHeaders(),
                    );
                    assertSame('{"chat_id":123,"text":"test"}', $request->getBody()->getContents());
                    return true;
                }),
            )
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', '//url/sendMessage')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->post(
            '//url/sendMessage',
            '{"chat_id":123,"text":"test"}',
            [
                'Content-Length' => '29',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        );

        assertSame(201, $response->statusCode);
    }

    public function testPostWithFiles(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    assertInstanceOf(Request::class, $request);
                    /** @var Request $request */
                    $requestHeaders = $request->getHeaders();
                    assertSame(['Content-Length', 'Content-Type'], array_keys($requestHeaders));
                    assertSame($requestHeaders['Content-Length'], ['332']);
                    assertSame([0], array_keys($requestHeaders['Content-Type']));
                    assertSame(
                        1,
                        preg_match(
                            '~multipart/form-data; boundary=([\da-f]+.[\da-f]+); charset=utf-8~',
                            $requestHeaders['Content-Type'][0],
                            $matches,
                        ),
                    );
                    assertStringContainsStringIgnoringLineEndings(
                        <<<TEXT
                            --$matches[1]
                            Content-Disposition: form-data; name="chat_id"

                            123
                            --$matches[1]
                            Content-Disposition: form-data; name="caption"

                            hello
                            --$matches[1]
                            Content-Disposition: form-data; name="photo"; filename="face.png"
                            Content-Type: image/png

                            test-file-body
                            --$matches[1]--
                            TEXT,
                        $request->getBody()->getContents(),
                    );
                    return true;
                }),
            )
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', '//url/sendPhoto')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->postWithFiles(
            '//url/sendPhoto',
            [
                'chat_id' => 123,
                'caption' => 'hello',
            ],
            [
                'photo' => new InputFile(
                    (new StreamFactory())->createStream('test-file-body'),
                    'face.png',
                ),
            ],
        );

        assertSame(201, $response->statusCode);
    }

    public function testRewind(): void
    {
        $streamFactory = new StreamFactory();

        $httpResponse = new Response(201, body: $streamFactory->createStream('hello'));
        $httpResponse->getBody()->getContents();

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($httpResponse);

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);

        $transport = new PsrTransport(
            $client,
            $httpRequestFactory,
            $streamFactory,
        );

        $response = $transport->get('getMe');

        assertSame(201, $response->statusCode);
        assertSame('hello', $response->body);
    }
}
