<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\Payment\RevenueWithdrawalState;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStateFailed;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStatePending;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStateSucceeded;

/**
 * @template-extends InterfaceValue<RevenueWithdrawalState>
 */
final readonly class RevenueWithdrawalStateValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'pending' => RevenueWithdrawalStatePending::class,
            'succeeded' => RevenueWithdrawalStateSucceeded::class,
            'failed' => RevenueWithdrawalStateFailed::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown revenue withdrawal state type.';
    }
}
