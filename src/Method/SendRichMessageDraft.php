<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InputRichMessage;

/**
 * @see https://core.telegram.org/bots/api#sendrichmessagedraft
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SendRichMessageDraft implements MethodInterface
{
    public function __construct(
        private int $chatId,
        private int $draftId,
        private InputRichMessage $richMessage,
        private ?int $messageThreadId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendRichMessageDraft';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'draft_id' => $this->draftId,
                'rich_message' => $this->richMessage->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
