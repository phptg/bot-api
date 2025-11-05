<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmediapreview
 *
 * @api
 */
final readonly class PaidMediaPreview implements PaidMedia
{
    public function __construct(
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
    ) {}

    public function getType(): string
    {
        return 'preview';
    }
}
