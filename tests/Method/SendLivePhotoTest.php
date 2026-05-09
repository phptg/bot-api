<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendLivePhoto;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendLivePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendLivePhoto(
            12,
            'fid1',
            'fid2',
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendLivePhoto', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'live_photo' => 'fid1',
                'photo' => 'fid2',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $livePhotoFile = new InputFile(null, 'video.mp4');
        $photoFile = new InputFile(null, 'photo.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendLivePhoto(
            12,
            $livePhotoFile,
            $photoFile,
            'bcid1',
            99,
            123,
            'Caption',
            'HTML',
            [$entity],
            false,
            true,
            false,
            false,
            true,
            'meID',
            new SuggestedPostParameters(
                new SuggestedPostPrice('USD', 10),
            ),
            $replyParameters,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'live_photo' => 'attach://file0',
                'photo' => 'attach://file1',
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'has_spoiler' => true,
                'disable_notification' => false,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meID',
                'suggested_post_parameters' => (new SuggestedPostParameters(
                    new SuggestedPostPrice('USD', 10),
                ))->toRequestArray(),
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
                'file0' => $livePhotoFile,
                'file1' => $photoFile,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendLivePhoto(
            12,
            'fid1',
            'fid2',
        );

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
