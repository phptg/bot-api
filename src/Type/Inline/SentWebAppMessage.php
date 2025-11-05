<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#sentwebappmessage
 *
 * @api
 */
final readonly class SentWebAppMessage
{
    public function __construct(
        public string $inlineMessageId,
    ) {}
}
