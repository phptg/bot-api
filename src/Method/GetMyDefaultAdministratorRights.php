<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatAdministratorRights;

/**
 * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
 *
 * @template-implements MethodInterface<ChatAdministratorRights>
 */
final readonly class GetMyDefaultAdministratorRights implements MethodInterface
{
    public function __construct(
        private ?bool $forChannels = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyDefaultAdministratorRights';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'for_channels' => $this->forChannels,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(ChatAdministratorRights::class);
    }
}
