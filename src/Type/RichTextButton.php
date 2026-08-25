<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtextbutton
 *
 * @api
 */
final readonly class RichTextButton implements RichText
{
    public function __construct(
        public RichMessageButton $button,
    ) {}

    public function getType(): string
    {
        return 'button';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'button' => $this->button->toRequestArray(),
        ];
    }
}
