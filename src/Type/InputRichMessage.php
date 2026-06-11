<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inputrichmessage
 *
 * @api
 */
final readonly class InputRichMessage
{
    public function __construct(
        public ?string $html = null,
        public ?string $markdown = null,
        public ?true $isRtl = null,
        public ?true $skipEntityDetection = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'html' => $this->html,
                'markdown' => $this->markdown,
                'is_rtl' => $this->isRtl,
                'skip_entity_detection' => $this->skipEntityDetection,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
