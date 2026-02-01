<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\ResourceReader;

use Psr\Http\Message\StreamInterface;

/**
 * Resource reader for PSR-7 streams.
 *
 * This reader handles PSR-7 {@see StreamInterface} instances, which are commonly
 * used in PSR-7 HTTP message implementations.
 *
 * @implements ResourceReaderInterface<StreamInterface>
 *
 * @api
 */
final class StreamResourceReader implements ResourceReaderInterface
{
    /**
     * @param StreamInterface $resource The PSR-7 stream to read from.
     *
     * @return string The content of the stream.
     */
    public function read(mixed $resource): string
    {
        if ($resource->isSeekable()) {
            $resource->rewind();
        }

        return $resource->getContents();
    }

    /**
     * @param StreamInterface $resource The PSR-7 stream to get URI from.
     *
     * @return string The stream URI.
     */
    public function getUri(mixed $resource): string
    {
        /**
         * @var string
         */
        return $resource->getMetadata('uri');
    }

    public function supports(mixed $resource): bool
    {
        return $resource instanceof StreamInterface;
    }
}
