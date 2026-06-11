<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtextanchor
 *
 * @api
 */
final readonly class RichTextAnchor implements RichText
{
    public function __construct(
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'anchor';
    }
}
