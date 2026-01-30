<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\ResourceReader;

use Psr\Http\Message\StreamInterface;

/**
 * @implements ResourceReaderInterface<StreamInterface>
 *
 * @api
 */
final class StreamResourceReader implements ResourceReaderInterface
{
    public function read(mixed $resource): string
    {
        if ($resource->isSeekable()) {
            $resource->rewind();
        }

        return $resource->getContents();
    }

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
