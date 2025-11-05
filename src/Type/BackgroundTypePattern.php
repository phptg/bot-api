<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypepattern
 *
 * @api
 */
final readonly class BackgroundTypePattern implements BackgroundType
{
    public function __construct(
        public Document $document,
        public BackgroundFill $fill,
        public int $intensity,
        public ?true $isInverted = null,
        public ?true $isMoving = null,
    ) {}

    public function getType(): string
    {
        return 'pattern';
    }
}
