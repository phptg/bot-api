<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatsharethemeuniquegift
 *
 * @api
 */
final readonly class ChatShareThemeUniqueGift implements ChatShareTheme
{
    public function __construct(
        public UniqueGift $gift,
    ) {}

    public function getType(): string
    {
        return 'unique_gift';
    }
}
