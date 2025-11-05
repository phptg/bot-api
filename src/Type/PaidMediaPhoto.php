<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#paidmediaphoto
 *
 * @api
 */
final readonly class PaidMediaPhoto implements PaidMedia
{
    /**
     * @param PhotoSize[] $photo
     */
    public function __construct(
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public array $photo,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }
}
