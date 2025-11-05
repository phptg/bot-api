<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult;

final class InvalidTypeOfValueInResultException extends TelegramParseResultException
{
    public function __construct(?string $key, mixed $value, string $expectedType)
    {
        $message = 'Invalid type of value';
        if ($key !== null) {
            $message .= ' for key "' . $key . '"';
        }
        $message .= '. Expected type is "' . $expectedType . '", but got "' . get_debug_type($value) . '".';
        parent::__construct($message);
    }
}
