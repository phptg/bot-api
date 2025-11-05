<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#upgradegift
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class UpgradeGift implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private string $ownedGiftId,
        private ?bool $keepOriginalDetails = null,
        private ?int $starCount = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'upgradeGift';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'owned_gift_id' => $this->ownedGiftId,
                'keep_original_details' => $this->keepOriginalDetails,
                'star_count' => $this->starCount,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
