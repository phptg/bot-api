<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquerytypesigndata
 *
 * @api
 */
final readonly class WidgetQueryTypeSignData implements WidgetQueryType
{
    public function __construct(
        public WidgetQueryWallet $wallet,
        public string $signData,
    ) {}

    public function getType(): string
    {
        return 'sign_data';
    }
}
