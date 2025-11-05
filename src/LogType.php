<?php

declare(strict_types=1);

namespace Phptg\BotApi;

/**
 * @api
 */
final readonly class LogType
{
    public const SEND_REQUEST = 1;
    public const SUCCESS_RESULT = 2;
    public const FAIL_RESULT = 3;
    public const PARSE_RESULT_ERROR = 4;
}
