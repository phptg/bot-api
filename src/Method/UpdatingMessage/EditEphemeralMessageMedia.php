<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputMedia;

/**
 * @see https://core.telegram.org/bots/api#editephemeralmessagemedia
 *
 * @template-implements MethodInterface<true>
 */
final readonly class EditEphemeralMessageMedia implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $receiverUserId,
        private int $ephemeralMessageId,
        private InputMedia $media,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editEphemeralMessageMedia';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $media = $this->media->toRequestArray($fileCollector);

        return array_filter(
            [
                'chat_id' => $this->chatId,
                'receiver_user_id' => $this->receiverUserId,
                'ephemeral_message_id' => $this->ephemeralMessageId,
                'media' => $media,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
