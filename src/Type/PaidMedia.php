<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmedia
 *
 * @api
 */
interface PaidMedia
{
    public function getType(): string;
}
