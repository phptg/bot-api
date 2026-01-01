<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftcolors
 *
 * @api
 */
final readonly class UniqueGiftColors
{
    /**
     * @param int[] $lightThemeOtherColors
     * @param int[] $darkThemeOtherColors
     */
    public function __construct(
        public string $modelCustomEmojiId,
        public string $symbolCustomEmojiId,
        public int $lightThemeMainColor,
        #[ArrayMap(IntegerValue::class)]
        public array $lightThemeOtherColors,
        public int $darkThemeMainColor,
        #[ArrayMap(IntegerValue::class)]
        public array $darkThemeOtherColors,
    ) {}
}
