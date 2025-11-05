<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\Transport\ApiResponse;
use Phptg\BotApi\Type\ResponseParameters;

/**
 * @api
 */
final readonly class FailResult
{
    public function __construct(
        public MethodInterface $method,
        public ApiResponse $response,
        public ?string $description = null,
        public ?ResponseParameters $parameters = null,
        public ?int $errorCode = null,
    ) {}
}
