<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquery
 *
 * @api
 */
final readonly class WidgetQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $chatInstance,
        public WidgetQueryType $type,
        public string $data,
        public ?Chat $chat = null,
        public ?int $messageId = null,
        public ?string $inlineMessageId = null,
        public ?string $chatType = null,
        public ?string $widgetId = null,
    ) {}
}
