<?php

declare(strict_types=1);

namespace Phptg\BotApi\WebhookResponse;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InputFile;

/**
 * Represents a Telegram Bot API method as a webhook response.
 *
 * You can respond to webhook updates by returning a JSON-serialized method in the HTTP response body. This allows you
 * to make one Bot API request without waiting for a response from your server.
 *
 * Important: webhook responses do not support file uploads (methods using {@see InputFile}). Use {@see isSupported()}
 * to check if a method can be sent via webhook response.
 *
 * @see https://core.telegram.org/bots/faq#how-can-i-make-requests-in-response-to-updates
 *
 * @api
 */
final readonly class WebhookResponse
{
    private string $apiMethod;
    private array $apiData;

    /**
     * @param MethodInterface $method The Telegram Bot API method to be sent as webhook response.
     */
    public function __construct(MethodInterface $method)
    {
        $this->apiMethod = $method->getApiMethod();
        $this->apiData = $method->getData();
    }

    /**
     * Returns the data array for the webhook response.
     * The returned array contains the method name and all method parameters.
     *
     * @return array The webhook response data.
     *
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function getData(): array
    {
        $this->assertSupport();

        return [
            'method' => $this->apiMethod,
            ...$this->apiData,
        ];
    }

    /**
     * Checks if the method can be sent via webhook response.
     *
     * Returns `false` if the method uses {@see InputFile}, as file uploads cannot be sent via webhook responses.
     *
     * @return bool `true` if the method is supported, `false` otherwise.
     */
    public function isSupported(): bool
    {
        try {
            $this->assertSupport();
            return true;
        } catch (MethodNotSupportedException) {
            return false;
        }
    }

    /**
     * Asserts that the method supports webhook responses.
     *
     * @throws MethodNotSupportedException If {@see InputFile} is used in method data.
     */
    private function assertSupport(): void
    {
        foreach ($this->apiData as $value) {
            if ($value instanceof InputFile) {
                throw new MethodNotSupportedException('InputFile is not supported in Webhook response.');
            }
        }
    }
}
