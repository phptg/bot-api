<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendVideo;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendVideoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVideo(12, 'https://example.com/wow.mp4');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendVideo', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'video' => 'https://example.com/wow.mp4',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $video = new InputFile((new StreamFactory())->createStream('test'), 'test.mp4');
        $thumbnail = new InputFile((new StreamFactory())->createStream('test'), 'test.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVideo(
            12,
            $video,
            'bcid1',
            99,
            500,
            300,
            200,
            $thumbnail,
            'Caption',
            'HTML',
            [$entity],
            false,
            true,
            false,
            false,
            true,
            'meID',
            $replyParameters,
            $replyMarkup,
            true,
            'attach://file1',
            17,
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
                'video' => $video,
                'duration' => 500,
                'width' => 300,
                'height' => 200,
                'thumbnail' => $thumbnail,
                'cover' => 'attach://file1',
                'start_timestamp' => 17,
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'has_spoiler' => true,
                'supports_streaming' => false,
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
        $method = new SendVideo(12, 'https://example.com/wow.mp4');

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
