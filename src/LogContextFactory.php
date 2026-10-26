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
     * @template TResult
     * @param MethodInterface<TResult> $method
     * @return array{
     *     type: LogType::SEND_REQUEST,
     *     payload: array<string, mixed>,
     *     method: MethodInterface<TResult>,
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
     * @template TResult
     * @template TDecodedResponse of array<mixed>
     * @param MethodInterface<TResult> $method
     * @param TDecodedResponse $decodedResponse
     * @return array{
     *     type: LogType::SUCCESS_RESULT,
     *     payload: TDecodedResponse,
     *     method: MethodInterface<TResult>,
     *     response: ApiResponse,
     *     decodedResponse: TDecodedResponse,
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
     * @template TResult
     * @template TDecodedResponse of array<mixed>
     * @param MethodInterface<TResult> $method
     * @param TDecodedResponse $decodedResponse
     * @return array{
     *     type: LogType::FAIL_RESULT,
     *     payload: string,
     *     method: MethodInterface<TResult>,
     *     response: ApiResponse,
     *     decodedResponse: TDecodedResponse,
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
