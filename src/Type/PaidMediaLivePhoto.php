<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmedialivephoto
 *
 * @api
 */
final readonly class PaidMediaLivePhoto implements PaidMedia
{
    public function __construct(
        public LivePhoto $livePhoto,
    ) {}

    public function getType(): string
    {
        return 'live_photo';
    }
}
