<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtext
 *
 * @api
 *
 * @phpstan-type RichTextContent = string|RichText|list<string|RichText|list<string|RichText|list<mixed>>>
 */
interface RichText
{
    public function getType(): string;

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array;
}
