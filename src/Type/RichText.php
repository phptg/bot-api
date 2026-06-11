<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtext
 *
 * @api
 */
interface RichText
{
    public function getType(): string;
}
