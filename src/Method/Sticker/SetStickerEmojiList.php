<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickeremojilist
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetStickerEmojiList implements MethodInterface
{
    /**
     * @param string[] $emojiList
     */
    public function __construct(
        private string $sticker,
        private array $emojiList,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerEmojiList';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
            'emoji_list' => $this->emojiList,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
