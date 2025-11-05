<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\SetStickerMaskPosition;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Sticker\MaskPosition;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerMaskPositionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerMaskPosition('sid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerMaskPosition', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $maskPosition = new MaskPosition('forehead', 0.5, 0.5, 45);
        $method = new SetStickerMaskPosition('sid', $maskPosition);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerMaskPosition', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
                'mask_position' => $maskPosition->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerMaskPosition('sid');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
