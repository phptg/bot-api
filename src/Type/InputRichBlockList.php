<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblocklist
 *
 * @api
 */
final readonly class InputRichBlockList implements InputRichBlock
{
    /**
     * @param InputRichBlockListItem[] $items
     */
    public function __construct(
        public array $items,
    ) {}

    public function getType(): string
    {
        return 'list';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'items' => array_map(
                static fn(InputRichBlockListItem $item) => $item->toRequestArray($fileCollector),
                $this->items,
            ),
        ];
    }
}
