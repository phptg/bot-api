<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\SetCustomEmojiStickerSetThumbnail;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetCustomEmojiStickerSetThumbnailTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setCustomEmojiStickerSetThumbnail', $method->getApiMethod());
        assertSame(
            [
                'name' => 'animals_by_my_bot',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot', 'ceid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setCustomEmojiStickerSetThumbnail', $method->getApiMethod());
        assertSame(
            [
                'name' => 'animals_by_my_bot',
                'custom_emoji_id' => 'ceid',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
