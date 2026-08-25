<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\FileCollector;
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
        private ?bool $canStop = null,
        private ?bool $keepOnStop = null,
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
        $fileCollector = new FileCollector();

        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'draft_id' => $this->draftId,
                'rich_message' => $this->richMessage->toRequestArray($fileCollector),
                'can_stop' => $this->canStop,
                'keep_on_stop' => $this->keepOnStop,
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
