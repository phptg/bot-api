<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\OwnedGift;
use Phptg\BotApi\Type\OwnedGiftRegular;
use Phptg\BotApi\Type\OwnedGiftUnique;

/**
 * @template-extends InterfaceValue<OwnedGift>
 */
final readonly class OwnedGiftValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'regular' => OwnedGiftRegular::class,
            'unique' => OwnedGiftUnique::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown owned gift type.';
    }
}
