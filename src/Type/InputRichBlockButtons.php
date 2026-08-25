<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockbuttons
 *
 * @api
 */
final readonly class InputRichBlockButtons implements InputRichBlock
{
    /**
     * @param RichMessageButton[] $buttons
     */
    public function __construct(
        public array $buttons,
        public ?string $align = null,
    ) {}

    public function getType(): string
    {
        return 'buttons';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'buttons' => array_map(
                    static fn(RichMessageButton $button) => $button->toRequestArray(),
                    $this->buttons,
                ),
                'align' => $this->align,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
