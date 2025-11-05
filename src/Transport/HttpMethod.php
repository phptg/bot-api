<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

/**
 * @api
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
}
