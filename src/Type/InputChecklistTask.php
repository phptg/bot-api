<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inputchecklisttask
 *
 * @api
 */
final readonly class InputChecklistTask
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public int $id,
        public string $text,
        public ?string $parseMode = null,
        public ?array $textEntities = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'id' => $this->id,
                'text' => $this->text,
                'parse_mode' => $this->parseMode,
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
