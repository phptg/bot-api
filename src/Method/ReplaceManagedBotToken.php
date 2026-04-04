<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#replacemanagedbottoken
 *
 * @template-implements MethodInterface<string>
 */
final readonly class ReplaceManagedBotToken implements MethodInterface
{
    public function __construct(
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'replaceManagedBotToken';
    }

    public function getData(): array
    {
        return ['user_id' => $this->userId];
    }

    public function getResultType(): StringValue
    {
        return new StringValue();
    }
}
