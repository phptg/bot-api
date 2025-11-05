<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

use Psr\Log\LoggerInterface;
use Phptg\BotApi\Transport\ApiResponse;
use Phptg\BotApi\TelegramBotApi;

final readonly class TestHelper
{
    public static function createSuccessStubApi(
        mixed $result,
        ?LoggerInterface $logger = null,
    ): TelegramBotApi {
        $response = $result instanceof ApiResponse
            ? $result
            : new ApiResponse(
                200,
                json_encode(['ok' => true, 'result' => $result], JSON_THROW_ON_ERROR),
            );
        return new TelegramBotApi(
            'stub-token',
            transport: new TransportMock($response),
            logger: $logger,
        );
    }
}
