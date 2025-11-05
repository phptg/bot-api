<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\StrictTypeRequest;

use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Phptg\BotApi\Transport\PsrTransport;

use function PHPUnit\Framework\assertSame;

final class StrictTypeRequestTest extends TestCase
{
    public function testWithHeader(): void
    {
        $streamFactory = new StreamFactory();

        $httpResponse = new Response(201, body: $streamFactory->createStream('hello'));

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($httpResponse);

        $transport = new PsrTransport(
            $client,
            new StrictTypeRequestFactory(),
            $streamFactory,
        );

        $response = $transport->get('getMyName');

        assertSame(201, $response->statusCode);
        assertSame('hello', $response->body);
    }
}
