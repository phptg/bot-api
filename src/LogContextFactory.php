<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use Phptg\BotApi\Transport\ApiResponse;

/**
 * @internal
 */
final class LogContextFactory
{
    /**
     * @return array{
     *     type: LogType::SEND_REQUEST,
     *     payload: array<string, mixed>,
     *     method: MethodInterface,
     * }
     */
    public static function sendRequest(MethodInterface $method): array
    {
        return [
            'type' => LogType::SEND_REQUEST,
            'payload' => $method->getData(),
            'method' => $method,
        ];
    }

    /**
     * @param array<mixed> $decodedResponse
     * @return array{
     *     type: LogType::SUCCESS_RESULT,
     *     payload: array<mixed>,
     *     method: MethodInterface,
     *     response: ApiResponse,
     *     decodedResponse: array<mixed>,
     * }
     */
    public static function successResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedResponse,
    ): array {
        return [
            'type' => LogType::SUCCESS_RESULT,
            'payload' => $decodedResponse,
            'method' => $method,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @param array<mixed> $decodedResponse
     * @return array{
     *     type: LogType::FAIL_RESULT,
     *     payload: string,
     *     method: MethodInterface,
     *     response: ApiResponse,
     *     decodedResponse: array<mixed>,
     * }
     */
    public static function failResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedResponse,
    ): array {
        return [
            'type' => LogType::FAIL_RESULT,
            'payload' => $response->body,
            'method' => $method,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @return array{
     *     type: LogType::PARSE_RESULT_ERROR,
     *     payload: string,
     * }
     */
    public static function parseResultError(string $raw): array
    {
        return [
            'type' => LogType::PARSE_RESULT_ERROR,
            'payload' => $raw,
        ];
    }
}
