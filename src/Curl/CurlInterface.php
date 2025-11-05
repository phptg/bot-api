<?php

declare(strict_types=1);

namespace Phptg\BotApi\Curl;

use CurlHandle;
use CurlShareHandle;

/**
 * @internal
 */
interface CurlInterface
{
    public function close(CurlHandle $handle): void;

    /**
     * @throws CurlException
     */
    public function exec(CurlHandle $handle): ?string;

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed;

    /**
     * @throws CurlException
     */
    public function init(): CurlHandle;

    /**
     * @throws CurlException
     */
    public function setopt_array(CurlHandle $handle, array $options): void;

    /**
     * @throws CurlException
     */
    public function share_setopt(CurlShareHandle $handle, int $option, mixed $value): void;
}
