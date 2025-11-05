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
    ) {}

    public function toRequestArray(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }
}
