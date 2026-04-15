<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#sending-files
 *
 * @api
 */
final readonly class InputFile
{
    /**
     * @param string|resource $pathOrResource
     */
    public function __construct(
        public mixed $pathOrResource,
        public ?string $sendName = null,
    ) {}

    public function filename(): ?string
    {
        if ($this->sendName !== null) {
            return $this->sendName;
        }

        if (is_string($this->pathOrResource)) {
            return basename($this->pathOrResource);
        }

        $uri = stream_get_meta_data($this->pathOrResource)['uri'];

        return str_contains($uri, '://') ? null : basename($uri);
    }

    public function extension(): ?string
    {
        $filename = $this->filename();

        return $filename === null ? null : pathinfo($filename, PATHINFO_EXTENSION);
    }
}
