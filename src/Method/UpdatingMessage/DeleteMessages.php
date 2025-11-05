<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletemessages
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteMessages implements MethodInterface
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        private int|string $chatId,
        private array $messageIds,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMessages';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_ids' => $this->messageIds,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
