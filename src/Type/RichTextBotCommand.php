<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextbotcommand
 *
 * @api
 */
final readonly class RichTextBotCommand implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $botCommand,
    ) {}

    public function getType(): string
    {
        return 'bot_command';
    }
}
