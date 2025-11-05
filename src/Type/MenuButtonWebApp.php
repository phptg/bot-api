<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#menubuttonwebapp
 *
 * @api
 */
final readonly class MenuButtonWebApp implements MenuButton
{
    public function __construct(
        public string $text,
        public WebAppInfo $webApp,
    ) {}

    public function getType(): string
    {
        return 'web_app';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => $this->text,
            'web_app' => $this->webApp->toRequestArray(),
        ];
    }
}
