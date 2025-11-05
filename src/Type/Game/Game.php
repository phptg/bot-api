<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Game;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Type\Animation;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#game
 *
 * @api
 */
final readonly class Game
{
    /**
     * @param PhotoSize[] $photo
     * @param MessageEntity[] $textEntities
     */
    public function __construct(
        public string $title,
        public string $description,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public array $photo,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $textEntities = null,
        public ?Animation $animation = null,
    ) {}
}
