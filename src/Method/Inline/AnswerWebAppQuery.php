<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Inline;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Inline\InlineQueryResult;
use Phptg\BotApi\Type\Inline\SentWebAppMessage;

/**
 * @see https://core.telegram.org/bots/api#answerwebappquery
 *
 * @template-implements MethodInterface<SentWebAppMessage>
 */
final readonly class AnswerWebAppQuery implements MethodInterface
{
    public function __construct(
        private string $webAppQueryId,
        private InlineQueryResult $result,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerWebAppQuery';
    }

    public function getData(): array
    {
        return [
            'web_app_query_id' => $this->webAppQueryId,
            'result' => $this->result->toRequestArray(),
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(SentWebAppMessage::class);
    }
}
