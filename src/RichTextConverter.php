<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use InvalidArgumentException;
use Phptg\BotApi\Type\RichText;

use function array_map;
use function array_values;
use function get_debug_type;
use function is_array;
use function is_string;

/**
 * @internal
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final class RichTextConverter
{
    /**
     * @param RichTextContent|null $value
     *
     * @return string|array<array-key, mixed>|null
     *
     * @throws InvalidArgumentException If the value contains an element that is not a string, a `RichText` object or
     * an array of them.
     */
    public static function toRequestArray(array|string|RichText|null $value): string|array|null
    {
        if ($value === null) {
            return null;
        }

        return self::convert($value);
    }

    /**
     * @return string|array<array-key, mixed>
     */
    private static function convert(mixed $value): string|array
    {
        if (is_string($value)) {
            return $value;
        }

        if ($value instanceof RichText) {
            return $value->toRequestArray();
        }

        if (is_array($value)) {
            return array_map(self::convert(...), array_values($value));
        }

        throw new InvalidArgumentException(
            'Rich text must be a string, a RichText object or an array of them. ' . get_debug_type($value) . ' given.',
        );
    }
}
