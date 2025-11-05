<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Update;

use SensitiveParameter;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setwebhook
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetWebhook implements MethodInterface
{
    public function __construct(
        private string $url,
        private ?string $ipAddress = null,
        private ?int $maxConnections = null,
        private ?array $allowUpdates = null,
        private ?bool $dropPendingUpdates = null,
        #[SensitiveParameter]
        private ?string $secretToken = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setWebhook';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'url' => $this->url,
                'ip_address' => $this->ipAddress,
                'max_connections' => $this->maxConnections,
                'allowed_updates' => $this->allowUpdates,
                'drop_pending_updates' => $this->dropPendingUpdates,
                'secret_token' => $this->secretToken,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
