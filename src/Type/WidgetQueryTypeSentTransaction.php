<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquerytypesenttransaction
 *
 * @api
 */
final readonly class WidgetQueryTypeSentTransaction implements WidgetQueryType
{
    public function __construct(
        public WidgetQueryWallet $wallet,
        public string $msgHash,
    ) {}

    public function getType(): string
    {
        return 'sent_transaction';
    }
}
