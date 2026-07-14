<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblocksectionheading
 *
 * @api
 */
final readonly class InputRichBlockSectionHeading implements InputRichBlock
{
    public function __construct(
        public string|array|RichText $text,
        public int $size,
    ) {}

    public function getType(): string
    {
        return 'heading';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'size' => $this->size,
        ];
    }
}
