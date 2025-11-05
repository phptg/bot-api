<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setchatstickerset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatStickerSet implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private string $stickerSetName,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatStickerSet';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'sticker_set_name' => $this->stickerSetName,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
