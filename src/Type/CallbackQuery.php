<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\MaybeInaccessibleMessageValue;

/**
 * @see https://core.telegram.org/bots/api#callbackquery
 *
 * @api
 */
final readonly class CallbackQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $chatInstance,
        #[MaybeInaccessibleMessageValue]
        public Message|InaccessibleMessage|null $message = null,
        public ?string $inlineMessageId = null,
        public ?string $data = null,
        public ?string $gameShortName = null,
    ) {}
}
