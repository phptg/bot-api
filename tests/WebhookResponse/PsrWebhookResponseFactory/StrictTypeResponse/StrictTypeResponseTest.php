<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\WebhookResponse\PsrWebhookResponseFactory\StrictTypeResponse;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\PsrWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;

final class StrictTypeResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new PsrWebhookResponseFactory(
            new StrictTypeResponseFactory(),
            new StreamFactory(),
        );
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
}
