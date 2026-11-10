<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquerytype
 *
 * @api
 */
interface WidgetQueryType
{
    public function getType(): string;
}
