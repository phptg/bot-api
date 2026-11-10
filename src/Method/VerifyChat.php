<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#verifychat
 *
 * @template-implements MethodInterface<true>
 */
final readonly class VerifyChat implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $customDescriptionEntities
     */
    public function __construct(
        private int|string $chatId,
        private ?string $customDescription = null,
        private ?string $customDescriptionParseMode = null,
        private ?array $customDescriptionEntities = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'verifyChat';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'custom_description' => $this->customDescription,
                'custom_description_parse_mode' => $this->customDescriptionParseMode,
                'custom_description_entities' => $this->customDescriptionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->customDescriptionEntities,
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
