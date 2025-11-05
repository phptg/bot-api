<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\SendSticker;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendStickerTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendSticker(12, 'https://example.com/sticker.webp');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendSticker', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'sticker' => 'https://example.com/sticker.webp',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $sticker = new InputFile((new StreamFactory())->createStream());
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendSticker(
            12,
            $sticker,
            'bcid1',
            99,
            '👍',
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
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'sticker' => $sticker,
                'emoji' => '👍',
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
        $method = new SendSticker(12, 'https://example.com/sticker.webp');

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
