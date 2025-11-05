<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetCustomEmojiStickerSetThumbnail implements MethodInterface
{
    public function __construct(
        private string $name,
        private ?string $customEmojiId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setCustomEmojiStickerSetThumbnail';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'name' => $this->name,
                'custom_emoji_id' => $this->customEmojiId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
