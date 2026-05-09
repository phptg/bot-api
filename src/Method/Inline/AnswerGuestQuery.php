<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Inline;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Inline\InlineQueryResult;
use Phptg\BotApi\Type\SentGuestMessage;

/**
 * @see https://core.telegram.org/bots/api#answerguestquery
 *
 * @template-implements MethodInterface<SentGuestMessage>
 */
final readonly class AnswerGuestQuery implements MethodInterface
{
    public function __construct(
        private string $guestQueryId,
        private InlineQueryResult $result,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerGuestQuery';
    }

    public function getData(): array
    {
        return [
            'guest_query_id' => $this->guestQueryId,
            'result' => $this->result->toRequestArray(),
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(SentGuestMessage::class);
    }
}
