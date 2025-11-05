<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsource
 *
 * @api
 */
interface ChatBoostSource
{
    public function getSource(): string;

    public function getUser(): ?User;
}
