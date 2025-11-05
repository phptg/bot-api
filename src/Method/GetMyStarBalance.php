<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\StarAmount;

/**
 * @see https://core.telegram.org/bots/api#getmystarbalance
 *
 * @template-implements MethodInterface<StarAmount>
 */
final readonly class GetMyStarBalance implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyStarBalance';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(StarAmount::class);
    }
}
