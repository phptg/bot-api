<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

use Psr\Log\LoggerInterface;
use RuntimeException;
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

    /**
     * Creates a pair of connected sockets. Such stream resources have no URI in their metadata.
     *
     * @return array{resource, resource}
     */
    public static function createSocketPair(): array
    {
        $pair = stream_socket_pair(
            PHP_OS_FAMILY === 'Windows' ? STREAM_PF_INET : STREAM_PF_UNIX,
            STREAM_SOCK_STREAM,
            STREAM_IPPROTO_IP,
        );
        if ($pair === false) {
            throw new RuntimeException('Failed to create a socket pair.');
        }
        return $pair;
    }
}
