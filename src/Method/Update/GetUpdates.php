<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Update;

use InvalidArgumentException;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\LongPollingMethodInterface;
use Phptg\BotApi\Type\Update\Update;

/**
 * @see https://core.telegram.org/bots/api#getupdates
 *
 * @template-implements LongPollingMethodInterface<array<Update>>
 */
final readonly class GetUpdates implements LongPollingMethodInterface
{
    /**
     * @param non-negative-int|null $timeout
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        private ?int $offset = null,
        private ?int $limit = null,
        private ?int $timeout = null,
        private ?array $allowedUpdates = null,
    ) {
        if ($this->timeout < 0) {
            throw new InvalidArgumentException(
                'The "timeout" must be a non-negative integer. ' . $this->timeout . ' given.',
            );
        }
    }

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

    public function getLongPollingTimeout(): int
    {
        return $this->timeout ?? 0;
    }

    /**
     * @return ArrayOfObjectsValue<Update>
     */
    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Update::class);
    }
}
