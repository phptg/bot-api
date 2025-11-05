<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\ParseResult\ValueProcessor\RawValue;
use Phptg\BotApi\ParseResult\ValueProcessor\ValueProcessorInterface;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @template TResult
 * @template-implements MethodInterface<TResult>
 *
 * @api
 */
final readonly class CustomMethod implements MethodInterface
{
    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-param ValueProcessorInterface<TResult> $resultType
     */
    public function __construct(
        private string $apiMethod,
        private array $data = [],
        private ValueProcessorInterface $resultType = new RawValue(),
        private HttpMethod $httpMethod = HttpMethod::POST,
    ) {}

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getResultType(): ValueProcessorInterface
    {
        return $this->resultType;
    }

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }
}
