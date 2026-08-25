<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#disabledbutton
 *
 * @api
 */
final readonly class DisabledButton
{
    public function toRequestArray(): array
    {
        return [];
    }
}
