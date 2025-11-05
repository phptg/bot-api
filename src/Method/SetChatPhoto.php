<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#setchatphoto
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatPhoto implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private InputFile $photo,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatPhoto';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'photo' => $this->photo,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
