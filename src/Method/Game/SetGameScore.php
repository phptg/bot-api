<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Game;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#setgamescore
 *
 * @template-implements MethodInterface<Message|true>
 */
final readonly class SetGameScore implements MethodInterface
{
    public function __construct(
        private int $userId,
        private int $score,
        private ?bool $force = null,
        private ?bool $disableEditMessage = null,
        private ?int $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setGameScore';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'score' => $this->score,
                'force' => $this->force,
                'disable_edit_message' => $this->disableEditMessage,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
