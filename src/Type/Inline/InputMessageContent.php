<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#inputmessagecontent
 *
 * @api
 */
interface InputMessageContent
{
    public function toRequestArray(): array;
}
