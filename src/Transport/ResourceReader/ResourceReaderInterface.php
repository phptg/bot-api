<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\ResourceReader;

/**
 * Interface for reading content from various resource types stored in {@see InputFile} objects.
 *
 * @template T
 *
 * @api
 */
interface ResourceReaderInterface
{
    /**
     * Reads the content from the given resource.
     *
     * @param T $resource The resource to read from.
     *
     * @return string The content of the resource.
     */
    public function read(mixed $resource): string;

    /**
     * Returns the URI of the given resource.
     *
     * @param T $resource The resource to get URI from.
     *
     * @return string The resource URI.
     */
    public function getUri(mixed $resource): string;

    /**
     * Checks if this reader supports the given resource.
     *
     * @param mixed $resource The resource to check.
     *
     * @return bool `true` if the resource is supported, `false` otherwise.
     */
    public function supports(mixed $resource): bool;
}
