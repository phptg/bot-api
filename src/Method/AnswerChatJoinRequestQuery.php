<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#answerchatjoinrequestquery
 *
 * @template-implements MethodInterface<true>
 */
final readonly class AnswerChatJoinRequestQuery implements MethodInterface
{
    public function __construct(
        private string $chatJoinRequestQueryId,
        private string $result,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerChatJoinRequestQuery';
    }

    public function getData(): array
    {
        return [
            'chat_join_request_query_id' => $this->chatJoinRequestQueryId,
            'result' => $this->result,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
