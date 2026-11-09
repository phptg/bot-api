<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widgetquerywallet
 *
 * @api
 */
final readonly class WidgetQueryWallet
{
    public function __construct(
        public string $address,
        public string $amount,
        public ?string $publicKey = null,
        public ?string $stateInit = null,
    ) {}
}
