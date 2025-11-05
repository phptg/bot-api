<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#editmessagelivelocation
 *
 * @template-implements MethodInterface<Message|true>
 */
final readonly class EditMessageLiveLocation implements MethodInterface
{
    public function __construct(
        private float $latitude,
        private float $longitude,
        private ?string $businessConnectionId = null,
        private int|string|null $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
        private ?int $livePeriod = null,
        private ?float $horizontalAccuracy = null,
        private ?int $heading = null,
        private ?int $proximityAlertRadius = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editMessageLiveLocation';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'live_period' => $this->livePeriod,
                'horizontal_accuracy' => $this->horizontalAccuracy,
                'heading' => $this->heading,
                'proximity_alert_radius' => $this->proximityAlertRadius,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
