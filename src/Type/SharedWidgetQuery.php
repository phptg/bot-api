<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#sharedwidgetquery
 *
 * @api
 */
final readonly class SharedWidgetQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public WidgetQueryType $type,
        public string $data,
        public string $widgetId,
    ) {}
}
