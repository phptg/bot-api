<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblocklistitem
 *
 * @api
 */
final readonly class InputRichBlockListItem
{
    /**
     * @param InputRichBlock[] $blocks
     */
    public function __construct(
        public array $blocks,
        public ?true $hasCheckbox = null,
        public ?true $isChecked = null,
        public ?int $value = null,
        public ?string $type = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'blocks' => array_map(
                    static fn(InputRichBlock $block) => $block->toRequestArray($fileCollector),
                    $this->blocks,
                ),
                'has_checkbox' => $this->hasCheckbox,
                'is_checked' => $this->isChecked,
                'value' => $this->value,
                'type' => $this->type,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
