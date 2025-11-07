<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use JsonException;
use Psr\Log\LoggerInterface;
use SensitiveParameter;
use Phptg\BotApi\ParseResult\ResultFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Transport\ApiResponse;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Transport\TransportInterface;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\ResponseParameters;

use function array_key_exists;
use function is_array;
use function is_bool;
use function is_int;
use function is_scalar;
use function is_string;
use function json_decode;
use function strlen;

/**
 * @internal
 */
final readonly class Api
{
    private ResultFactory $resultFactory;

    public function __construct(
        #[SensitiveParameter]
        private string $token,
        private string $baseUrl,
        private TransportInterface $transport,
    ) {
        $this->resultFactory = new ResultFactory();
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     *
     * @psalm-template TValue
     * @psalm-param MethodInterface<TValue> $method
     * @psalm-return TValue|FailResult
     */
    public function call(MethodInterface $method, ?LoggerInterface $logger): mixed
    {
        $logger?->info(
            'Send ' . $method->getHttpMethod()->value . '-request "' . $method->getApiMethod() . '".',
            LogContextFactory::sendRequest($method),
        );

        $url = $this->baseUrl . '/bot' . $this->token . '/' . $method->getApiMethod();
        $response = match ($method->getHttpMethod()) {
            HttpMethod::GET => $this->sendGetRequest($url, $method->getData()),
            HttpMethod::POST => $this->sendPostRequest($url, $method->getData()),
        };

        try {
            $decodedBody = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $logger?->error(
                'Failed to decode JSON from telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Failed to decode JSON response. Status code: ' . $response->statusCode . '.',
                previous: $e,
            );
        }

        if (!is_array($decodedBody)) {
            $logger?->error(
                'Incorrect telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Expected telegram response as array. Got "' . get_debug_type($decodedBody) . '".',
            );
        }

        if (!isset($decodedBody['ok']) || !is_bool($decodedBody['ok'])) {
            $logger?->error(
                'Incorrect "ok" field in telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Incorrect "ok" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        if ($decodedBody['ok']) {
            $result = $this->prepareSuccessResult($method, $response, $decodedBody, $logger);
            $logger?->info(
                'On "' . $method->getApiMethod() . '" request Telegram Bot API returned successful result.',
                LogContextFactory::successResult($method, $response, $decodedBody),
            );
        } else {
            $result = $this->prepareFailResult($method, $response, $decodedBody);
            $logger?->warning(
                'On "' . $method->getApiMethod() . '" request Telegram Bot API returned fail result.',
                LogContextFactory::failResult($method, $response, $decodedBody),
            );
        }

        return $result;
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function sendGetRequest(string $url, array $data): ApiResponse
    {
        $queryParameters = array_map(
            static fn($value) => is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
            $data,
        );

        if (!empty($queryParameters)) {
            $url .= '?' . http_build_query($queryParameters);
        }

        return $this->transport->get($url);
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function sendPostRequest(string $url, array $data): ApiResponse
    {
        $files = [];
        foreach ($data as $key => $value) {
            if ($value instanceof InputFile) {
                $files[$key] = $value;
                unset($data[$key]);
            }
        }

        if (empty($files)) {
            $content = json_encode($data, JSON_THROW_ON_ERROR);
            return $this->transport->post(
                $url,
                $content,
                [
                    'Content-Length' => (string) strlen($content),
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
            );
        }

        $data = array_map(
            static fn(mixed $value) => is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
            $data,
        );

        return $this->transport->postWithFiles($url, $data, $files);
    }

    /**
     * @psalm-template TValue
     * @psalm-param MethodInterface<TValue> $method
     * @psalm-return TValue
     */
    private function prepareSuccessResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedBody,
        ?LoggerInterface $logger,
    ): mixed {
        if (!array_key_exists('result', $decodedBody)) {
            $logger?->error(
                'Not found "result" field in telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Not found "result" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        $resultType = $method->getResultType();

        try {
            return $this->resultFactory->create($decodedBody['result'], $resultType);
        } catch (TelegramParseResultException $exception) {
            $logger?->error(
                'Failed to parse telegram result. ' . $exception->getMessage(),
                LogContextFactory::parseResultError($response->body),
            );
            throw $exception;
        }
    }

    private function prepareFailResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedBody,
    ): FailResult {
        return new FailResult(
            $method,
            $response,
            (isset($decodedBody['description']) && is_string($decodedBody['description']))
                ? $decodedBody['description']
                : null,
            ResponseParameters::fromDecodedBody($decodedBody),
            (isset($decodedBody['error_code']) && is_int($decodedBody['error_code']))
                ? $decodedBody['error_code']
                : null,
        );
    }
}
