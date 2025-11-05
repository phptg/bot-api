<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Psr\Http\Message\StreamInterface;
use Phptg\BotApi\Type\InputFile;

use function is_resource;

/**
 * @internal
 */
final readonly class FileHelper
{
    public static function read(InputFile $file): string
    {
        return is_resource($file->resource)
            ? self::readResource($file->resource)
            : self::readStream($file->resource);
    }

    public static function extension(InputFile $file): ?string
    {
        $filepath = self::filepath($file);
        return $filepath === null
            ? null
            : pathinfo($filepath, PATHINFO_EXTENSION);
    }

    public static function basename(InputFile $file): ?string
    {
        $filepath = self::filepath($file);
        return $filepath === null
            ? null
            : basename($filepath);
    }

    private static function filepath(InputFile $file): ?string
    {
        if ($file->filename !== null) {
            return $file->filename;
        }

        /**
         * @var string $uri
         */
        $uri = is_resource($file->resource)
            ? stream_get_meta_data($file->resource)['uri']
            : $file->resource->getMetadata('uri');

        if (str_contains($uri, '://')) {
            return null;
        }

        return $uri;
    }

    /**
     * @param resource $resource
     */
    private static function readResource(mixed $resource): string
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

    private static function readStream(StreamInterface $stream): string
    {
        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        return $stream->getContents();
    }
}
