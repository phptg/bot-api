<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquerytypedata
 *
 * @api
 */
final readonly class WidgetQueryTypeData implements WidgetQueryType
{
    public function __construct(
        public ?TonWalletCard $walletCard = null,
    ) {}

    public function getType(): string
    {
        return 'data';
    }
}
