<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputRichMessage;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#editephemeralmessagetext
 *
 * @template-implements MethodInterface<true>
 */
final readonly class EditEphemeralMessageText implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        private int|string $chatId,
        private int $receiverUserId,
        private int $ephemeralMessageId,
        private ?string $text = null,
        private ?string $parseMode = null,
        private ?array $entities = null,
        private ?LinkPreviewOptions $linkPreviewOptions = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
        private ?InputRichMessage $richMessage = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editEphemeralMessageText';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();

        return array_filter(
            [
                'chat_id' => $this->chatId,
                'receiver_user_id' => $this->receiverUserId,
                'ephemeral_message_id' => $this->ephemeralMessageId,
                'text' => $this->text,
                'parse_mode' => $this->parseMode,
                'entities' => $this->entities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->entities,
                ),
                'rich_message' => $this->richMessage?->toRequestArray($fileCollector),
                'link_preview_options' => $this->linkPreviewOptions?->toRequestArray(),
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
