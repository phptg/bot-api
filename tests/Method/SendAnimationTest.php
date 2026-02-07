<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendAnimation;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendAnimation(12, 'https://example.com/anime.gif');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendAnimation', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'animation' => 'https://example.com/anime.gif',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $animation = new InputFile(null, 'test.gif');
        $thumbnail = new InputFile(null, 'test.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendAnimation(
            12,
            $animation,
            'bcid1',
            99,
            100,
            240,
            320,
            $thumbnail,
            'Caption',
            'HTML',
            [$entity],
            true,
            false,
            false,
            true,
            'meID',
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
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'animation' => $animation,
                'duration' => 100,
                'width' => 240,
                'height' => 320,
                'thumbnail' => $thumbnail,
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'has_spoiler' => false,
                'disable_notification' => false,
                'protect_content' => true,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meID',
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
        $method = new SendAnimation(12, 'https://example.com/anime.gif');

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
