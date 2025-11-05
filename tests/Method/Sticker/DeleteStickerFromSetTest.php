<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\DeleteStickerFromSet;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteStickerFromSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStickerFromSet('id');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteStickerFromSet', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'id',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStickerFromSet('id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
