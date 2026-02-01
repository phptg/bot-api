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
    /**
     * @param mixed $resource The file resource.
     * @param string|null $filename Optional filename to use when sending the file.
     */
    public function __construct(
        public mixed $resource,
        public ?string $filename = null,
    ) {}

    /**
     * Creates an instance from a local file path.
     *
     * @param string $path Path to the local file.
     * @param string|null $filename Optional filename to use when sending the file.
     *
     * @return self The created instance.
     *
     * @throws RuntimeException If the file cannot be opened.
     */
    public static function fromLocalFile(string $path, ?string $filename = null): self
    {
        $resource = fopen($path, 'r');
        if ($resource === false) {
            throw new RuntimeException('Unable to open file "' . $path . '".');
        }
        return new self($resource, $filename);
    }
}
