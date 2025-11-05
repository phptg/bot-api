<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Update;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#webhookinfo
 *
 * @api
 */
final readonly class WebhookInfo
{
    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        public string $url,
        public bool $hasCustomCertificate,
        public int $pendingUpdateCount,
        public ?string $ipAddress = null,
        public ?DateTimeImmutable $lastErrorDate = null,
        public ?string $lastErrorMessage = null,
        public ?DateTimeImmutable $lastSynchronizationErrorDate = null,
        public ?int $maxConnections = null,
        #[ArrayMap(StringValue::class)]
        public ?array $allowedUpdates = null,
    ) {}
}
