<?php

declare(strict_types=1);

namespace Phptg\BotApi;

/**
 * Represents a downloaded file from the Telegram servers.
 *
 * @api
 */
final readonly class DownloadedFile
{
    /**
     * @param resource $stream A `php://temp` stream with the file content, rewound to the beginning.
     */
    public function __construct(
        private mixed $stream,
    ) {}

    /**
     * Returns the stream with the file content.
     *
     * @return resource  the stream with the file content (`php://temp` resource).
     */
    public function getStream(): mixed
    {
        return $this->stream;
    }

    /**
     * Saves the file content to the specified path.
     *
     * @throws SaveFileException If an error occurred while saving the file.
     */
    public function saveTo(string $path): void
    {
        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new SaveFileException($errorString);
            },
        );
        try {
            file_put_contents($path, $this->stream);
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Returns the file content as a string.
     */
    public function getBody(): string
    {
        /**
         * @var string We expect the stream to be valid, so `stream_get_contents()` returns string.
         */
        return stream_get_contents($this->stream);
    }
}
