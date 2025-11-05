<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#copytextbutton
 *
 * @api
 */
final readonly class CopyTextButton
{
    public function __construct(
        public string $text,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'text' => $this->text,
        ];
    }
}
