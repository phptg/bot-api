<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Payment;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Payment\ShippingOption;

/**
 * @see https://core.telegram.org/bots/api#answershippingquery
 *
 * @template-implements MethodInterface<true>
 */
final readonly class AnswerShippingQuery implements MethodInterface
{
    /**
     * @param ShippingOption[]|null $shippingOptions
     */
    public function __construct(
        private string $shippingQueryId,
        private bool $ok,
        private ?array $shippingOptions = null,
        private ?string $errorMessage = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerShippingQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'shipping_query_id' => $this->shippingQueryId,
                'ok' => $this->ok,
                'shipping_options' => $this->shippingOptions === null ? null : array_map(
                    static fn(ShippingOption $option) => $option->toRequestArray(),
                    $this->shippingOptions,
                ),
                'error_message' => $this->errorMessage,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
