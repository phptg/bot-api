<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockdocument
 *
 * @api
 */
final readonly class InputRichBlockDocument implements InputRichBlock
{
    public function __construct(
        public InputMediaDocument $document,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'document';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'document' => $this->document->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
