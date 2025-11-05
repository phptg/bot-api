<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#unpinallgeneralforumtopicmessages
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class UnpinAllGeneralForumTopicMessages implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'unpinAllGeneralForumTopicMessages';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
