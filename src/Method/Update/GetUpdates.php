<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Update;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Update\Update;

/**
 * @see https://core.telegram.org/bots/api#getupdates
 *
 * @template-implements MethodInterface<array<Update>>
 */
final readonly class GetUpdates implements MethodInterface
{
    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        private ?int $offset = null,
        private ?int $limit = null,
        private ?int $timeout = null,
        private ?array $allowedUpdates = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUpdates';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'offset' => $this->offset,
                'limit' => $this->limit,
                'timeout' => $this->timeout,
                'allowed_updates' => $this->allowedUpdates,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Update::class);
    }
}
