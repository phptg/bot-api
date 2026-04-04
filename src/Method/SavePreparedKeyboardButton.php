<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\KeyboardButton;
use Phptg\BotApi\Type\PreparedKeyboardButton;

/**
 * @see https://core.telegram.org/bots/api#savepreparedkeyboardbutton
 *
 * @template-implements MethodInterface<PreparedKeyboardButton>
 */
final readonly class SavePreparedKeyboardButton implements MethodInterface
{
    public function __construct(
        private int $userId,
        private KeyboardButton $button,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'savePreparedKeyboardButton';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'button' => $this->button->toRequestArray(),
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(PreparedKeyboardButton::class);
    }
}
