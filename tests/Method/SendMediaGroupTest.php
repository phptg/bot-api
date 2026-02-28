<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMediaGroup;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class SendMediaGroupTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaPhoto('https://example.com/face.png');
        $method = new SendMediaGroup(12, [$inputMedia]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendMediaGroup', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'media' => [$inputMedia->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile(null);
        $inputMedia = new InputMediaPhoto($file);
        $replyParameters = new ReplyParameters(23);
        $method = new SendMediaGroup(
            12,
            [$inputMedia],
            'bcid',
            99,
            true,
            false,
            'id1',
            $replyParameters,
            true,
            123,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'media' => [
                    [
                        'type' => 'photo',
                        'media' => 'attach://file0',
                    ],
                ],
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'id1',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendMediaGroup(12, []);

        $result = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ])->call($method);

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(Message::class, $result[0]);
        assertSame(7, $result[0]->messageId);
    }
}
