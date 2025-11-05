<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundfill
 *
 * @api
 */
interface BackgroundFill
{
    public function getType(): string;
}
