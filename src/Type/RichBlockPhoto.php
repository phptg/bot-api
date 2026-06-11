<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#richblockphoto
 *
 * @api
 */
final readonly class RichBlockPhoto implements RichBlock
{
    /**
     * @param list<PhotoSize> $photo
     */
    public function __construct(
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public array $photo,
        public ?true $hasSpoiler = null,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }
}
