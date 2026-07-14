<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\Type\RichText;

use function array_map;
use function is_string;

/**
 * @internal
 */
final class RichTextConverter
{
    /**
     * @return string|array<array-key, mixed>|null
     */
    public static function toRequestArray(array|string|RichText|null $value): string|array|null
    {
        if ($value === null || is_string($value)) {
            return $value;
        }

        if ($value instanceof RichText) {
            return $value->toRequestArray();
        }

        return array_map(
            self::toRequestArray(...),
            $value,
        );
    }
}
