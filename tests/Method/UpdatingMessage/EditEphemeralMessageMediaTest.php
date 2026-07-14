<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\EditEphemeralMessageMedia;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditEphemeralMessageMediaTest extends TestCase
{
    public function testBase(): void
    {
        $media = new InputMediaPhoto('https://example.com/photo.jpg');
        $method = new EditEphemeralMessageMedia(23, 45, 34, $media);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editEphemeralMessageMedia', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'media' => $media->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $media = new InputMediaPhoto('https://example.com/photo.jpg');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditEphemeralMessageMedia(23, 45, 34, $media, $replyMarkup);

        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'media' => $media->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFileCollectorIsUsedForMedia(): void
    {
        $file = new InputFile(null);
        $media = new InputMediaPhoto($file);
        $method = new EditEphemeralMessageMedia(23, 45, 34, $media);

        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'media' => [
                    'type' => 'photo',
                    'media' => 'attach://file0',
                ],
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditEphemeralMessageMedia(23, 45, 34, new InputMediaPhoto('https://example.com/photo.jpg'));

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);
    }
}
