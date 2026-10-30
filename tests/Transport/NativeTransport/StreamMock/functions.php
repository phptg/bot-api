<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock\StreamMock;

/**
 * Overrides `http_get_last_response_headers()` for `NativeTransport` (PHP 8.4+), because a userland stream wrapper
 * can't set the last response headers.
 *
 * @return list<string>|null
 */
function http_get_last_response_headers(): ?array
{
    return StreamMock::getLastResponseHeaders();
}
