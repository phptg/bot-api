<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 *
 * @api
 */
final readonly class LinkPreviewOptions
{
    public function __construct(
        public ?bool $isDisabled = null,
        public ?string $url = null,
        public ?bool $preferSmallMedia = null,
        public ?bool $preferLargeMedia = null,
        public ?bool $showAboveText = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'is_disabled' => $this->isDisabled,
                'url' => $this->url,
                'prefer_small_media' => $this->preferSmallMedia,
                'prefer_large_media' => $this->preferLargeMedia,
                'show_above_text' => $this->showAboveText,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
