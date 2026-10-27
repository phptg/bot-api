<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockparagraph
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class InputRichBlockParagraph implements InputRichBlock
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        public string|array|RichText $text,
    ) {}

    public function getType(): string
    {
        return 'paragraph';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
        ];
    }
}
