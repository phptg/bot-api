<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfArraysOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 *
 * @api
 */
final readonly class InlineKeyboardMarkup
{
    /**
     * @param array[] $inlineKeyboard
     * @psalm-param array<array-key, array<array-key, InlineKeyboardButton>> $inlineKeyboard
     */
    public function __construct(
        #[ArrayOfArraysOfObjectsValue(InlineKeyboardButton::class)]
        public array $inlineKeyboard,
        public ?bool $forceReply = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'inline_keyboard' => array_map(
                    static fn(array $buttons) => array_map(
                        static fn(InlineKeyboardButton $button) => $button->toRequestArray(),
                        $buttons,
                    ),
                    $this->inlineKeyboard,
                ),
                'force_reply' => $this->forceReply,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
