<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 *
 * @api
 */
interface ChatMember
{
    public function getStatus(): string;

    public function getUser(): User;
}
