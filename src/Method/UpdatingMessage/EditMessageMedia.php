<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputMedia;
use Phptg\BotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#editmessagemedia
 *
 * @template-implements MethodInterface<Message|true>
 */
final readonly class EditMessageMedia implements MethodInterface
{
    public function __construct(
        private InputMedia $media,
        private ?string $businessConnectionId = null,
        private int|string|null $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editMessageMedia';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $media = $this->media->toRequestArray($fileCollector);

        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
                'media' => $media,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
