<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendSharedWidget;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class SendSharedWidgetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendSharedWidget(12, 'widget123');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendSharedWidget', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'widget_id' => 'widget123',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendSharedWidget(
            12,
            'widget123',
            99,
            'secret',
            'Caption',
            'HTML',
            [$entity],
            true,
            true,
            false,
            true,
            'meID',
            $replyParameters,
            $replyMarkup,
        );

        assertSame(
            [
                'chat_id' => 12,
                'message_thread_id' => 99,
                'widget_id' => 'widget123',
                'chat_data' => 'secret',
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meID',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendSharedWidget(12, 'widget123');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertInstanceOf(Message::class, $preparedResult);
        assertSame(7, $preparedResult->messageId);
    }
}
