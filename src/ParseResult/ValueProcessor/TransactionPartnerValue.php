<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\Payment\TransactionPartner;
use Phptg\BotApi\Type\Payment\TransactionPartnerAffiliateProgram;
use Phptg\BotApi\Type\Payment\TransactionPartnerChat;
use Phptg\BotApi\Type\Payment\TransactionPartnerFragment;
use Phptg\BotApi\Type\Payment\TransactionPartnerOther;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramAds;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramApi;
use Phptg\BotApi\Type\Payment\TransactionPartnerUser;

/**
 * @template-extends InterfaceValue<TransactionPartner>
 */
final readonly class TransactionPartnerValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'affiliate_program' => TransactionPartnerAffiliateProgram::class,
            'fragment' => TransactionPartnerFragment::class,
            'telegram_ads' => TransactionPartnerTelegramAds::class,
            'telegram_api' => TransactionPartnerTelegramApi::class,
            'user' => TransactionPartnerUser::class,
            'chat' => TransactionPartnerChat::class,
            'other' => TransactionPartnerOther::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown transaction partner type.';
    }
}
