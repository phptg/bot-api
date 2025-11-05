<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtype
 *
 * @api
 */
interface BackgroundType
{
    public function getType(): string;
}
