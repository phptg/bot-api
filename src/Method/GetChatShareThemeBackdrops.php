<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatShareThemeBackdrops;

/**
 * @see https://core.telegram.org/bots/api#getchatsharethemebackdrops
 *
 * @template-implements MethodInterface<ChatShareThemeBackdrops>
 *
 * @api
 */
final readonly class GetChatShareThemeBackdrops implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatShareThemeBackdrops';
    }

    public function getData(): array
    {
        return [];
    }

    /**
     * @return ObjectValue<ChatShareThemeBackdrops>
     */
    public function getResultType(): ObjectValue
    {
        return new ObjectValue(ChatShareThemeBackdrops::class);
    }
}
