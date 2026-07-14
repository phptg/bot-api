<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockpreformatted
 *
 * @api
 */
final readonly class InputRichBlockPreformatted implements InputRichBlock
{
    public function __construct(
        public string|array|RichText $text,
        public ?string $language = null,
    ) {}

    public function getType(): string
    {
        return 'pre';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'text' => RichTextConverter::toRequestArray($this->text),
                'language' => $this->language,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
