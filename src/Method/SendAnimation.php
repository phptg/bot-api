<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyKeyboardMarkup;
use Phptg\BotApi\Type\ReplyKeyboardRemove;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#sendanimation
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendAnimation implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        private int|string $chatId,
        private InputFile|string $animation,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?int $duration = null,
        private ?int $width = null,
        private ?int $height = null,
        private InputFile|string|null $thumbnail = null,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?bool $showCaptionAboveMedia = null,
        private ?bool $hasSpoiler = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?bool $allowPaidBroadcast = null,
        private ?int $directMessagesTopicId = null,
        private ?SuggestedPostParameters $suggestedPostParameters = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendAnimation';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'animation' => $this->animation,
                'duration' => $this->duration,
                'width' => $this->width,
                'height' => $this->height,
                'thumbnail' => $this->thumbnail,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'has_spoiler' => $this->hasSpoiler,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'message_effect_id' => $this->messageEffectId,
                'suggested_post_parameters' => $this->suggestedPostParameters?->toRequestArray(),
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
