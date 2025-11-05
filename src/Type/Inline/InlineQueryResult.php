<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresult
 *
 * @api
 */
interface InlineQueryResult
{
    public function getType(): string;

    public function toRequestArray(): array;
}
