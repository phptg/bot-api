<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#sendchatjoinrequestwebapp
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SendChatJoinRequestWebApp implements MethodInterface
{
    public function __construct(
        private string $chatJoinRequestQueryId,
        private string $webAppUrl,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendChatJoinRequestWebApp';
    }

    public function getData(): array
    {
        return [
            'chat_join_request_query_id' => $this->chatJoinRequestQueryId,
            'web_app_url' => $this->webAppUrl,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
