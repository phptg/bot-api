<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#tonnft
 *
 * @api
 */
final readonly class TonNft
{
    /**
     * @param TonNftAttribute[]|null $attributes
     */
    public function __construct(
        public string $address,
        public string $index,
        public string $name,
        public string $description,
        public ?string $collectionAddress = null,
        #[ArrayOfObjectsValue(TonNftAttribute::class)]
        public ?array $attributes = null,
        public ?UniqueGift $gift = null,
    ) {}
}
