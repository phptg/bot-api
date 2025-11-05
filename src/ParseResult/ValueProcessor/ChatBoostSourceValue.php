<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\ChatBoostSource;
use Phptg\BotApi\Type\ChatBoostSourceGiftCode;
use Phptg\BotApi\Type\ChatBoostSourceGiveaway;
use Phptg\BotApi\Type\ChatBoostSourcePremium;

/**
 * @template-extends InterfaceValue<ChatBoostSource>
 */
final readonly class ChatBoostSourceValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'source';
    }

    public function getClassMap(): array
    {
        return [
            'premium' => ChatBoostSourcePremium::class,
            'gift_code' => ChatBoostSourceGiftCode::class,
            'giveaway' => ChatBoostSourceGiveaway::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown chat boost source.';
    }
}
