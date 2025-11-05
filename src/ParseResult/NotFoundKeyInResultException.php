<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult;

final class NotFoundKeyInResultException extends TelegramParseResultException
{
    public function __construct(string $key)
    {
        parent::__construct('Not found key "' . $key . '" in result object.');
    }
}
