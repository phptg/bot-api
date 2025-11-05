<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatAdministratorRights;

/**
 * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetMyDefaultAdministratorRights implements MethodInterface
{
    public function __construct(
        private ?ChatAdministratorRights $rights = null,
        private ?bool $forChannels = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyDefaultAdministratorRights';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'rights' => $this->rights?->toRequestArray(),
                'for_channels' => $this->forChannels,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
