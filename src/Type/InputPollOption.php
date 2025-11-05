<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inputpolloption
 *
 * @api
 */
final readonly class InputPollOption
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public ?string $text = null,
        public ?string $textParseMode = null,
        public ?array $textEntities = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
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
}
