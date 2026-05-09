<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotAccessSettings;

/**
 * @see https://core.telegram.org/bots/api#getmanagedbotaccesssettings
 *
 * @template-implements MethodInterface<BotAccessSettings>
 */
final readonly class GetManagedBotAccessSettings implements MethodInterface
{
    public function __construct(
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getManagedBotAccessSettings';
    }

    public function getData(): array
    {
        return ['user_id' => $this->userId];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(BotAccessSettings::class);
    }
}
