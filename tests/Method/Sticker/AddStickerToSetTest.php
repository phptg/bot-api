<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\AddStickerToSet;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\Sticker\InputSticker;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AddStickerToSetTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $inputSticker = new InputSticker($file, 'static', ['😀']);
        $method = new AddStickerToSet(1, 'test', $inputSticker);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('addStickerToSet', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'name' => 'test',
                'sticker' => [
                    'sticker' => 'attach://file0',
                    'format' => 'static',
                    'emoji_list' => ['😀'],
                ],
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AddStickerToSet(
            1,
            'test',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
