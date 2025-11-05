<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#webappdata
 *
 * @api
 */
final readonly class WebAppData
{
    public function __construct(
        public string $data,
        public string $buttonText,
    ) {}
}
