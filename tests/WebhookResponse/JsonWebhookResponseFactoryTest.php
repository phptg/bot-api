<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\WebhookResponse;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\JsonWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;

final class JsonWebhookResponseFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new JsonWebhookResponseFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');
        $webhookResponse = new WebhookResponse($method);

        $json = $factory->create($webhookResponse);

        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $json);
    }

    public function testByMethod(): void
    {
        $factory = new JsonWebhookResponseFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');

        $json = $factory->byMethod($method);

        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $json);
    }
}
