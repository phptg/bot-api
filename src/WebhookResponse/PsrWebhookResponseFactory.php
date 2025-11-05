<?php

declare(strict_types=1);

namespace Phptg\BotApi\WebhookResponse;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Phptg\BotApi\MethodInterface;

use function json_encode;

/**
 * Factory for creating PSR-7 HTTP responses for webhook handlers.
 *
 * The factory automatically:
 *
 * - encodes the data as JSON;
 * - sets the `Content-Type` header to "application/json; charset=utf-8";
 * - sets the `Content-Length` header.
 *
 * @api
 */
final readonly class PsrWebhookResponseFactory
{
    /**
     * @param ResponseFactoryInterface $responseFactory PSR-17 response factory for creating HTTP responses.
     * @param StreamFactoryInterface $streamFactory PSR-17 stream factory for creating response body streams.
     */
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * Creates a PSR-7 HTTP response from a webhook response.
     *
     * @param WebhookResponse $webhookResponse The webhook response containing the method to execute.
     *
     * @return ResponseInterface The PSR-7 HTTP response with JSON body and appropriate headers.
     *
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function create(WebhookResponse $webhookResponse): ResponseInterface
    {
        $body = $this->streamFactory->createStream(
            json_encode($webhookResponse->getData(), JSON_THROW_ON_ERROR),
        );

        return $this->responseFactory
            ->createResponse()
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Content-Length', (string) $body->getSize());
    }

    /**
     * Creates a PSR-7 HTTP response directly from a method.
     * This is a convenience method that creates a {@see WebhookResponse} internally.
     *
     * @param MethodInterface $method The Telegram Bot API method to be sent as webhook response.
     *
     * @return ResponseInterface The PSR-7 HTTP response with JSON body and appropriate headers.
     *
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byMethod(MethodInterface $method): ResponseInterface
    {
        return $this->create(new WebhookResponse($method));
    }
}
