<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\WebhookResponse\PsrWebhookResponseFactory;

use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\PsrWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;

final class PsrWebhookResponseFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = $this->createFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');
        $webhookResponse = new WebhookResponse($method);

        $response = $factory->create($webhookResponse);

        assertSame(
            [
                'Content-Type' => ['application/json; charset=utf-8'],
                'Content-Length' => ['54'],
            ],
            $response->getHeaders(),
        );
        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $response->getBody()->getContents());
    }

    public function testByMethod(): void
    {
        $factory = $this->createFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');

        $response = $factory->byMethod($method);

        assertSame(
            [
                'Content-Type' => ['application/json; charset=utf-8'],
                'Content-Length' => ['54'],
            ],
            $response->getHeaders(),
        );
        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $response->getBody()->getContents());
    }

    private function createFactory(): PsrWebhookResponseFactory
    {
        return new PsrWebhookResponseFactory(
            new ResponseFactory(),
            new StreamFactory(),
        );
    }
}
