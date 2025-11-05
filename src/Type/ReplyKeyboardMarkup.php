<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 *
 * @api
 */
final readonly class ReplyKeyboardMarkup
{
    /**
     * @param KeyboardButton[][] $keyboard
     * @psalm-param array<array-key, array<array-key, KeyboardButton>> $keyboard
     */
    public function __construct(
        public array $keyboard,
        public ?bool $isPersistent = null,
        public ?bool $resizeKeyboard = null,
        public ?bool $oneTimeKeyboard = null,
        public ?string $inputFieldPlaceholder = null,
        public ?bool $selective = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'keyboard' => array_map(
                    static fn(array $buttons) => array_map(
                        static fn(KeyboardButton $button) => $button->toRequestArray(),
                        $buttons,
                    ),
                    $this->keyboard,
                ),
                'is_persistent' => $this->isPersistent,
                'resize_keyboard' => $this->resizeKeyboard,
                'one_time_keyboard' => $this->oneTimeKeyboard,
                'input_field_placeholder' => $this->inputFieldPlaceholder,
                'selective' => $this->selective,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
