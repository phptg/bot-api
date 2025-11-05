<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Update;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Update\WebhookInfo;

/**
 * @see https://core.telegram.org/bots/api#getwebhookinfo
 *
 * @template-implements MethodInterface<WebhookInfo>
 */
final readonly class GetWebhookInfo implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getWebhookInfo';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(WebhookInfo::class);
    }
}
