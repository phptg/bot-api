<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#videochatended
 *
 * @api
 */
final readonly class VideoChatEnded
{
    public function __construct(
        public int $duration,
    ) {}
}
