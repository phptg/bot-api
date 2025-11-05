<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#giftpremiumsubscription
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class GiftPremiumSubscription implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        private int $userId,
        private int $monthCount,
        private int $starCount,
        private ?string $text = null,
        private ?string $textParseMode = null,
        private ?array $textEntities = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'giftPremiumSubscription';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'month_count' => $this->monthCount,
                'star_count' => $this->starCount,
                'text' => $this->text,
                'text_parse_mode' => $this->textParseMode,
                'text_entities' => $this->textEntities === null ? null : array_map(
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
