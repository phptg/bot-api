<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotFullInfo;

/**
 * @see https://core.telegram.org/bots/api#getme
 *
 * @template-implements MethodInterface<BotFullInfo>
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

    /**
     * @return ObjectValue<BotFullInfo>
     */
    public function getResultType(): ObjectValue
    {
        return new ObjectValue(BotFullInfo::class);
    }
}
