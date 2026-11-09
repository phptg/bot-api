<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#widget
 *
 * @api
 */
final readonly class Widget
{
    public function __construct(
        public string $html,
        public ?string $id = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $publicData = null,
        public ?string $chatData = null,
    ) {}
}
