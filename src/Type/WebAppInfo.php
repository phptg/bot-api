<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#webappinfo
 *
 * @api
 */
final readonly class WebAppInfo
{
    public function __construct(
        public string $url,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
