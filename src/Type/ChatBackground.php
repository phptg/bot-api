<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatbackground
 *
 * @api
 */
final readonly class ChatBackground
{
    public function __construct(
        public BackgroundType $type,
    ) {}
}
