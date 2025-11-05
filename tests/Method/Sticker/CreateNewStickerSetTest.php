<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\CreateNewStickerSet;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Sticker\InputSticker;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CreateNewStickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateNewStickerSet(1, 'test_by_bot', 'Test Pack', []);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createNewStickerSet', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'name' => 'test_by_bot',
                'title' => 'Test Pack',
                'stickers' => [],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $inputSticker = new InputSticker('https://example.com/test.png', 'static', ['😀']);
        $method = new CreateNewStickerSet(1, 'test_by_bot', 'Test Pack', [$inputSticker], 'regular', true);

        assertSame(
            [
                'user_id' => 1,
                'name' => 'test_by_bot',
                'title' => 'Test Pack',
                'stickers' => [$inputSticker->toRequestArray()],
                'sticker_type' => 'regular',
                'needs_repainting' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateNewStickerSet(1, 'test_by_bot', 'Test Pack', []);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
