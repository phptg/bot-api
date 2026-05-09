<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setmanagedbotaccesssettings
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetManagedBotAccessSettings implements MethodInterface
{
    /**
     * @param int[]|null $addedUserIds
     */
    public function __construct(
        private int $userId,
        private bool $isAccessRestricted,
        private ?array $addedUserIds = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setManagedBotAccessSettings';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'is_access_restricted' => $this->isAccessRestricted,
                'added_user_ids' => $this->addedUserIds,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
