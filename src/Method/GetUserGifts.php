<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\OwnedGifts;

/**
 * @see https://core.telegram.org/bots/api#getusergifts
 *
 * @template-implements MethodInterface<OwnedGifts>
 *
 * @api
 */
final readonly class GetUserGifts implements MethodInterface
{
    public function __construct(
        private int $userId,
        private ?bool $excludeUnlimited = null,
        private ?bool $excludeLimitedUpgradable = null,
        private ?bool $excludeLimitedNonUpgradable = null,
        private ?bool $excludeFromBlockchain = null,
        private ?bool $excludeUnique = null,
        private ?bool $sortByPrice = null,
        private ?string $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUserGifts';
    }

    public function getData(): array
    {
        return array_filter([
            'user_id' => $this->userId,
            'exclude_unlimited' => $this->excludeUnlimited,
            'exclude_limited_upgradable' => $this->excludeLimitedUpgradable,
            'exclude_limited_non_upgradable' => $this->excludeLimitedNonUpgradable,
            'exclude_from_blockchain' => $this->excludeFromBlockchain,
            'exclude_unique' => $this->excludeUnique,
            'sort_by_price' => $this->sortByPrice,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn($value) => $value !== null);
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(OwnedGifts::class);
    }
}
