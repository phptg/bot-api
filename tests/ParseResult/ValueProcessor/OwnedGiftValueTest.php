<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\OwnedGiftValue;
use Phptg\BotApi\Type\OwnedGiftRegular;
use Phptg\BotApi\Type\OwnedGiftUnique;

use function PHPUnit\Framework\assertInstanceOf;

final class OwnedGiftValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                OwnedGiftRegular::class,
                [
                    'type' => 'regular',
                    'gift' => [
                        'id' => 'test-id1',
                        'sticker' => [
                            'file_id' => 'x1',
                            'file_unique_id' => 'fullX1',
                            'type' => 'regular',
                            'width' => 100,
                            'height' => 120,
                            'is_animated' => false,
                            'is_video' => true,
                        ],
                        'star_count' => 11,
                    ],
                    'owned_gift_id' => 'ownedGiftId1',
                    'sender_user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'send_date' => 1619040000,
                    'text' => 'Hello',
                    'entities' => [
                        [
                            'type' => 'bold',
                            'offset' => 0,
                            'length' => 4,
                        ],
                    ],
                    'is_private' => true,
                    'is_saved' => true,
                    'can_be_upgraded' => true,
                    'was_refunded' => true,
                    'convert_star_count' => 10,
                    'prepaid_upgrade_star_count' => 5,
                ],
            ],
            [
                OwnedGiftUnique::class,
                [
                    'type' => 'unique',
                    'gift' => [
                        'gift_id' => 'gift-value-test',
                        'base_name' => 'BaseName',
                        'name' => 'uniqueName',
                        'number' => 1,
                        'model' => [
                            'name' => 'test1',
                            'sticker' => [
                                'file_id' => 'x1',
                                'file_unique_id' => 'fullX1',
                                'type' => 'unique',
                                'width' => 100,
                                'height' => 120,
                                'is_animated' => false,
                                'is_video' => true,
                            ],
                            'rarity_per_mille' => 200,
                        ],
                        'symbol' => [
                            'name' => 'test2',
                            'sticker' => [
                                'file_id' => 'x1',
                                'file_unique_id' => 'fullX1',
                                'type' => 'unique',
                                'width' => 100,
                                'height' => 120,
                                'is_animated' => false,
                                'is_video' => true,
                            ],
                            'rarity_per_mille' => 200,
                        ],
                        'backdrop' => [
                            'name' => 'test3',
                            'colors' => [
                                'center_color' => 1,
                                'edge_color' => 2,
                                'symbol_color' => 3,
                                'text_color' => 4,
                            ],
                            'rarity_per_mille' => 200,
                        ],
                    ],
                    'owned_gift_id' => 'ownedGiftId1',
                    'sender_user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'send_date' => 1619040000,
                    'is_saved' => true,
                    'can_be_transferred' => true,
                    'transfer_star_count' => 10,
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new OwnedGiftValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new OwnedGiftValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown owned gift type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
