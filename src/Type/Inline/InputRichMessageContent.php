<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InputRichMessage;

/**
 * @see https://core.telegram.org/bots/api#inputrichmessagecontent
 *
 * @api
 */
final readonly class InputRichMessageContent implements InputMessageContent
{
    public function __construct(
        public InputRichMessage $richMessage,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'rich_message' => $this->richMessage->toRequestArray(),
        ];
    }
}
