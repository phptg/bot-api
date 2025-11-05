<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\MenuButton;

/**
 * @see https://core.telegram.org/bots/api#setchatmenubutton
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatMenuButton implements MethodInterface
{
    public function __construct(
        private ?int $chatId = null,
        private ?MenuButton $menuButton = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatMenuButton';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'menu_button' => $this->menuButton?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
