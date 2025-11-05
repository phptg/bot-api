<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#getcustomemojistickers
 *
 * @template-implements MethodInterface<array<Sticker>>
 */
final readonly class GetCustomEmojiStickers implements MethodInterface
{
    /**
     * @param string[] $customEmojiIds
     */
    public function __construct(
        private array $customEmojiIds,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getCustomEmojiStickers';
    }

    public function getData(): array
    {
        return [
            'custom_emoji_ids' => $this->customEmojiIds,
        ];
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Sticker::class);
    }
}
