<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#preparedkeyboardbutton
 *
 * @api
 */
final readonly class PreparedKeyboardButton
{
    public function __construct(
        public string $id,
    ) {}
}
