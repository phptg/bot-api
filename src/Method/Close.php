<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#close
 *
 * @template-implements MethodInterface<true>
 */
final readonly class Close implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'close';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
