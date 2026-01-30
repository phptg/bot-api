<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\ResourceReader;

/**
 * @template T
 *
 * @api
 */
interface ResourceReaderInterface
{
    /**
     * @param T $resource
     */
    public function read(mixed $resource): string;

    /**
     * @param T $resource
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
