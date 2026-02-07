<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\WebhookResponse;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\Method\SendPhoto;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\WebhookResponse\MethodNotSupportedException;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertFalse;

final class WebhookResponseTest extends TestCase
{
    public function testSimpleMethodWithoutData(): void
    {
        $method = new SendMessage(chatId: 'x1', text: 'Hello');
        $webhookResponse = new WebhookResponse($method);

        $data = $webhookResponse->getData();

        assertTrue($webhookResponse->isSupported());
        assertSame(
            [
                'method' => 'sendMessage',
                'chat_id' => 'x1',
                'text' => 'Hello',
            ],
            $data,
        );
    }

    public function testMethodWithInputFile(): void
    {
        $method = new SendPhoto(
            chatId: 'x1',
            photo: new InputFile(null),
        );

        $webhookResponse = new WebhookResponse($method);

        assertFalse($webhookResponse->isSupported());

        $this->expectException(MethodNotSupportedException::class);
        $this->expectExceptionMessage('InputFile is not supported in Webhook response.');
        $webhookResponse->getData();
    }
}
