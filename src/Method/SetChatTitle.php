<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setchattitle
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatTitle implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private string $title,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatTitle';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'title' => $this->title,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
