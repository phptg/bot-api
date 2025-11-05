<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\MessageOrigin;
use Phptg\BotApi\Type\MessageOriginChannel;
use Phptg\BotApi\Type\MessageOriginChat;
use Phptg\BotApi\Type\MessageOriginHiddenUser;
use Phptg\BotApi\Type\MessageOriginUser;

/**
 * @template-extends InterfaceValue<MessageOrigin>
 */
final readonly class MessageOriginValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'user' => MessageOriginUser::class,
            'hidden_user' => MessageOriginHiddenUser::class,
            'chat' => MessageOriginChat::class,
            'channel' => MessageOriginChannel::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown message origin type.';
    }
}
