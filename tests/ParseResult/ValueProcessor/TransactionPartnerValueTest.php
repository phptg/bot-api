<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\TransactionPartnerValue;
use Phptg\BotApi\Type\Payment\TransactionPartnerAffiliateProgram;
use Phptg\BotApi\Type\Payment\TransactionPartnerChat;
use Phptg\BotApi\Type\Payment\TransactionPartnerFragment;
use Phptg\BotApi\Type\Payment\TransactionPartnerOther;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramAds;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramApi;
use Phptg\BotApi\Type\Payment\TransactionPartnerUser;

use function PHPUnit\Framework\assertInstanceOf;

final class TransactionPartnerValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                TransactionPartnerAffiliateProgram::class,
                [
                    'type' => 'affiliate_program',
                    'commission_per_mille' => 200,
                ],
            ],
            [
                TransactionPartnerFragment::class,
                [
                    'type' => 'fragment',
                ],
            ],
            [
                TransactionPartnerTelegramAds::class,
                [
                    'type' => 'telegram_ads',
                ],
            ],
            [
                TransactionPartnerTelegramApi::class,
                [
                    'type' => 'telegram_api',
                    'request_count' => 3,
                ],
            ],
            [
                TransactionPartnerUser::class,
                [
                    'type' => 'user',
                    'transaction_type' => 'premium_purchase',
                    'user' => [
                        'id' => 12,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                TransactionPartnerChat::class,
                [
                    'type' => 'chat',
                    'chat' => [
                        'id' => 12,
                        'type' => 'private',
                    ],
                ],
            ],
            [
                TransactionPartnerOther::class,
                [
                    'type' => 'other',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new TransactionPartnerValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new TransactionPartnerValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown transaction partner type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
