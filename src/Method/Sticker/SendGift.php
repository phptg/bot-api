<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#sendgift
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SendGift implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        private int $userId,
        private string $giftId,
        private ?string $text = null,
        private ?string $textParseMode = null,
        private ?array $textEntities = null,
        private ?bool $payForUpgrade = null,
        private int|string|null $chatId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendGift';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'chat_id' => $this->chatId,
                'gift_id' => $this->giftId,
                'pay_for_upgrade' => $this->payForUpgrade,
                'text' => $this->text,
                'text_parse_mode' => $this->textParseMode,
                'text_entities' => $this->textEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->textEntities,
                    ),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
