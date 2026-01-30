<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use RuntimeException;

/**
 * @see https://core.telegram.org/bots/api#sending-files
 *
 * @api
 */
final readonly class InputFile
{
    public function __construct(
        public mixed $resource,
        public ?string $filename = null,
    ) {}

    public static function fromLocalFile(string $path, ?string $filename = null): self
    {
        $resource = fopen($path, 'r');
        if ($resource === false) {
            throw new RuntimeException('Unable to open file "' . $path . '".');
        }
        return new self($resource, $filename);
    }
}
