<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#getchat
 *
 * @template-implements MethodInterface<User>
 */
final readonly class GetMe implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMe';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(User::class);
    }
}
