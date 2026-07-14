<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommand
 *
 * @api
 */
final readonly class BotCommand
{
    public function __construct(
        public string $command,
        public string $description,
        public ?bool $isEphemeral = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'command' => $this->command,
                'description' => $this->description,
                'is_ephemeral' => $this->isEphemeral,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
