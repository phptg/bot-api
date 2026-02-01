<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\ResourceReader;

use function is_resource;

/**
 * Resource reader for native PHP resources.
 *
 * This reader handles native PHP stream resources created by functions like
 * `fopen()`, `tmpfile()`, etc.
 *
 * @implements ResourceReaderInterface<resource>
 *
 * @api
 */
final class NativeResourceReader implements ResourceReaderInterface
{
    /**
     * @param resource $resource The native PHP resource to read from.
     *
     * @return string The content of the resource.
     */
    public function read(mixed $resource): string
    {
        $metadata = stream_get_meta_data($resource);
        if ($metadata['seekable']) {
            rewind($resource);
        }

        /**
         * @var string We assume that `$resource` is correct, so `stream_get_contents()` never returns `false`.
         */
        return stream_get_contents($resource);
    }

    /**
     * @param resource $resource The native PHP resource to get URI from.
     *
     * @return string The resource URI.
     */
    public function getUri(mixed $resource): string
    {
        return stream_get_meta_data($resource)['uri'];
    }

    public function supports(mixed $resource): bool
    {
        return is_resource($resource);
    }
}
