<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\ParseResult\ValueProcessor\ValueProcessorInterface;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @template-covariant TResult
 *
 * @api
 */
interface MethodInterface
{
    /**
     * @see https://core.telegram.org/bots/api#available-methods
     */
    public function getApiMethod(): string;

    /**
     * @return array<string, mixed>
     */
    public function getData(): array;

    /**
     * @return ValueProcessorInterface<TResult>
     */
    public function getResultType(): ValueProcessorInterface;

    public function getHttpMethod(): HttpMethod;
}
