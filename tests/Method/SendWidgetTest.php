<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendWidget;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class SendWidgetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendWidget(12, '<b>Hello</b>');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendWidget', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'html' => '<b>Hello</b>',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendWidget(
            12,
            '<b>Hello</b>',
            99,
            240,
            320,
            '{"foo":"bar"}',
            'secret',
            'Caption',
            'HTML',
            [$entity],
            true,
            true,
            false,
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
                'html' => '<b>Hello</b>',
                'width' => 240,
                'height' => 320,
                'public_data' => '{"foo":"bar"}',
                'chat_data' => 'secret',
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'allow_queries' => true,
                'is_shared' => false,
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
        $method = new SendWidget(12, '<b>Hello</b>');

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
