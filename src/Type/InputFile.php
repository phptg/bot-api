<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use function is_string;

/**
 * @see https://core.telegram.org/bots/api#sending-files
 *
 * @api
 */
final readonly class InputFile
{
    /**
     * @param string|resource $pathOrResource File path or open resource.
     * @param string|null $filename The filename sent to Telegram.
     */
    public function __construct(
        public mixed $pathOrResource,
        private ?string $filename = null,
    ) {}

    /**
     * Returns the filename to use when sending the file, or `null` if it cannot be determined.
     */
    public function filename(): ?string
    {
        if ($this->filename !== null) {
            return $this->filename;
        }

        if (is_string($this->pathOrResource)) {
            return basename($this->pathOrResource);
        }

        $uri = stream_get_meta_data($this->pathOrResource)['uri'];
        return str_contains($uri, '://') ? null : basename($uri);
    }

    /**
     * Returns the file extension derived from the filename, or `null` if it cannot be determined.
     */
    public function extension(): ?string
    {
        $filename = $this->filename();
        return $filename === null ? null : pathinfo($filename, PATHINFO_EXTENSION);
    }
}
