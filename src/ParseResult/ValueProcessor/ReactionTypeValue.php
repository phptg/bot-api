<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\ReactionType;
use Phptg\BotApi\Type\ReactionTypeCustomEmoji;
use Phptg\BotApi\Type\ReactionTypeEmoji;
use Phptg\BotApi\Type\ReactionTypePaid;

/**
 * @template-extends InterfaceValue<ReactionType>
 */
final readonly class ReactionTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'emoji' => ReactionTypeEmoji::class,
            'custom_emoji' => ReactionTypeCustomEmoji::class,
            'paid' => ReactionTypePaid::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown reaction type.';
    }
}
