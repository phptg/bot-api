<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richmessagebutton
 *
 * @api
 */
final readonly class RichMessageButton
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public ?string $style = null,
        public ?string $url = null,
        public ?string $callbackData = null,
        public ?WebAppInfo $webApp = null,
        public ?LoginUrl $loginUrl = null,
        public ?string $switchInlineQuery = null,
        public ?string $switchInlineQueryCurrentChat = null,
        public ?SwitchInlineQueryChosenChat $switchInlineQueryChosenChat = null,
        public ?CopyTextButton $copyText = null,
        public ?DisabledButton $disabled = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => RichTextConverter::toRequestArray($this->text),
                'style' => $this->style,
                'url' => $this->url,
                'callback_data' => $this->callbackData,
                'web_app' => $this->webApp?->toRequestArray(),
                'login_url' => $this->loginUrl?->toRequestArray(),
                'switch_inline_query' => $this->switchInlineQuery,
                'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
                'switch_inline_query_chosen_chat' => $this->switchInlineQueryChosenChat?->toRequestArray(),
                'copy_text' => $this->copyText?->toRequestArray(),
                'disabled' => $this->disabled?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
