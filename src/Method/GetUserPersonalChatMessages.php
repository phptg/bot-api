<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#getuserpersonalchatmessages
 *
 * @template-implements MethodInterface<array<Message>>
 */
final readonly class GetUserPersonalChatMessages implements MethodInterface
{
    public function __construct(
        private int $userId,
        private int $limit,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'getUserPersonalChatMessages';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'limit' => $this->limit,
        ];
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Message::class);
    }
}
