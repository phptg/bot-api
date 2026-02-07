<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendPhoto;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendPhoto(12, 'https://example.com/i.png');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendPhoto', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'photo' => 'https://example.com/i.png',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $photo = new InputFile(null, 'test.png');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendPhoto(
            12,
            $photo,
            'bcid1',
            99,
            'Caption',
            'parse',
            [$entity],
            true,
            false,
            true,
            false,
            'meid1',
            $replyParameters,
            $replyMarkup,
            true,
            123,
            new SuggestedPostParameters(
                new SuggestedPostPrice('USD', 10),
            ),
        );

        assertSame(
            [
                'chat_id' => 12,
                'photo' => $photo,
                'business_connection_id' => 'bcid1',
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'caption' => 'Caption',
                'parse_mode' => 'parse',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'has_spoiler' => false,
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meid1',
                'suggested_post_parameters' => [
                    'price' => [
                        'currency' => 'USD',
                        'amount' => 10,
                    ],
                ],
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendPhoto(12, 'https://example.com/i.png');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
