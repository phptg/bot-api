<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setuseremojistatus
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetUserEmojiStatus implements MethodInterface
{
    public function __construct(
        private int $userId,
        private ?string $emojiStatusCustomEmojiId = null,
        private ?DateTimeImmutable $emojiStatusExpirationDate = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setUserEmojiStatus';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'emoji_status_custom_emoji_id' => $this->emojiStatusCustomEmojiId,
                'emoji_status_expiration_date' => $this->emojiStatusExpirationDate?->getTimestamp(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
