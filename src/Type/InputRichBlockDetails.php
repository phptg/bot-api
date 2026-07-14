<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockdetails
 *
 * @api
 */
final readonly class InputRichBlockDetails implements InputRichBlock
{
    /**
     * @param InputRichBlock[] $blocks
     */
    public function __construct(
        public string|array|RichText $summary,
        public array $blocks,
        public ?true $isOpen = null,
    ) {}

    public function getType(): string
    {
        return 'details';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'summary' => RichTextConverter::toRequestArray($this->summary),
                'blocks' => array_map(
                    static fn(InputRichBlock $block) => $block->toRequestArray($fileCollector),
                    $this->blocks,
                ),
                'is_open' => $this->isOpen,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
