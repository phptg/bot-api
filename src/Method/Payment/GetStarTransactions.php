<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Payment;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Payment\StarTransactions;

/**
 * @see https://core.telegram.org/bots/api#getstartransactions
 *
 * @template-implements MethodInterface<StarTransactions>
 */
final readonly class GetStarTransactions implements MethodInterface
{
    public function __construct(
        private ?int $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getStarTransactions';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'offset' => $this->offset,
                'limit' => $this->limit,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(StarTransactions::class);
    }
}
