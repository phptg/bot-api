<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\OwnedGifts;

/**
 * @see https://core.telegram.org/bots/api#getbusinessaccountgifts
 *
 * @template-implements MethodInterface<OwnedGifts>
 *
 * @api
 */
final readonly class GetBusinessAccountGifts implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?bool $excludeUnsaved = null,
        private ?bool $excludeSaved = null,
        private ?bool $excludeUnlimited = null,
        private ?bool $excludeLimitedUpgradable = null,
        private ?bool $excludeLimitedNonUpgradable = null,
        private ?bool $excludeUnique = null,
        private ?bool $excludeFromBlockchain = null,
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
        return 'getBusinessAccountGifts';
    }

    public function getData(): array
    {
        return array_filter([
            'business_connection_id' => $this->businessConnectionId,
            'exclude_unsaved' => $this->excludeUnsaved,
            'exclude_saved' => $this->excludeSaved,
            'exclude_unlimited' => $this->excludeUnlimited,
            'exclude_limited_upgradable' => $this->excludeLimitedUpgradable,
            'exclude_limited_non_upgradable' => $this->excludeLimitedNonUpgradable,
            'exclude_unique' => $this->excludeUnique,
            'exclude_from_blockchain' => $this->excludeFromBlockchain,
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
