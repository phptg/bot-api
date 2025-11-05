<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\PaidMediaValue;
use Phptg\BotApi\Type\PaidMediaPhoto;
use Phptg\BotApi\Type\PaidMediaPreview;
use Phptg\BotApi\Type\PaidMediaVideo;

use function PHPUnit\Framework\assertInstanceOf;

final class PaidMediaValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                PaidMediaPreview::class,
                [
                    'type' => 'preview',
                    'width' => 100,
                    'height' => 100,
                    'duration' => 23,
                ],
            ],
            [
                PaidMediaPhoto::class,
                [
                    'type' => 'photo',
                    'photo' => [],
                ],
            ],
            [
                PaidMediaVideo::class,
                [
                    'type' => 'video',
                    'video' => [
                        'file_id' => 'f12',
                        'file_unique_id' => 'fu12',
                        'width' => 100,
                        'height' => 200,
                        'duration' => 23,
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new PaidMediaValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new PaidMediaValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown paid media type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
