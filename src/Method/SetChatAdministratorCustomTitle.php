<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatAdministratorCustomTitle implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private string $customTitle,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatAdministratorCustomTitle';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
            'custom_title' => $this->customTitle,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
