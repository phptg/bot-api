<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\RevenueWithdrawalStateValue;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStateFailed;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStatePending;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStateSucceeded;

use function PHPUnit\Framework\assertInstanceOf;

final class RevenueWithdrawalStateValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                RevenueWithdrawalStatePending::class,
                [
                    'type' => 'pending',
                ],
            ],
            [
                RevenueWithdrawalStateSucceeded::class,
                [
                    'type' => 'succeeded',
                    'date' => 12431326,
                    'url' => 'https://example.com/test',
                ],
            ],
            [
                RevenueWithdrawalStateFailed::class,
                [
                    'type' => 'failed',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new RevenueWithdrawalStateValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new RevenueWithdrawalStateValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown revenue withdrawal state type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
