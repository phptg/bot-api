<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblock
 *
 * @api
 */
interface RichBlock
{
    public function getType(): string;
}
