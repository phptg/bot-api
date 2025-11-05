<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Inline;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Inline\InlineQueryResult;
use Phptg\BotApi\Type\Inline\PreparedInlineMessage;

/**
 * @see https://core.telegram.org/bots/api#savepreparedinlinemessage
 *
 * @template-implements MethodInterface<PreparedInlineMessage>
 */
final readonly class SavePreparedInlineMessage implements MethodInterface
{
    public function __construct(
        private int $userId,
        private InlineQueryResult $result,
        private ?bool $allowUserChats = null,
        private ?bool $allowBotChats = null,
        private ?bool $allowGroupChats = null,
        private ?bool $allowChannelChats = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'savePreparedInlineMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'result' => $this->result->toRequestArray(),
                'allow_user_chats' => $this->allowUserChats,
                'allow_bot_chats' => $this->allowBotChats,
                'allow_group_chats' => $this->allowGroupChats,
                'allow_channel_chats' => $this->allowChannelChats,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(PreparedInlineMessage::class);
    }
}
