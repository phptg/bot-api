<?php

declare(strict_types=1);

namespace Phptg\BotApi\WebhookResponse;

use Phptg\BotApi\MethodInterface;

/**
 * Factory for creating JSON strings for webhook responses that can be sent in the HTTP response body.
 *
 * @api
 */
final readonly class JsonWebhookResponseFactory
{
    /**
     * Creates a JSON string from a webhook response.
     *
     * @param WebhookResponse $webhookResponse The webhook response containing the method to execute.
     *
     * @return string The JSON-encoded webhook response.
     *
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function create(WebhookResponse $webhookResponse): string
    {
        return json_encode($webhookResponse->getData(), JSON_THROW_ON_ERROR);
    }

    /**
     * Creates a JSON string directly from a method.
     * This is a convenience method that creates a {@see WebhookResponse} internally.
     *
     * @param MethodInterface $method The Telegram Bot API method to be sent as webhook response.
     *
     * @return string The JSON-encoded webhook response.
     *
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byMethod(MethodInterface $method): string
    {
        return $this->create(new WebhookResponse($method));
    }
}
