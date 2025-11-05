<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmediavideo
 *
 * @api
 */
final readonly class PaidMediaVideo implements PaidMedia
{
    public function __construct(
        public Video $video,
    ) {}

    public function getType(): string
    {
        return 'video';
    }
}
