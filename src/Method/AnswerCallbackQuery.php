<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#answercallbackquery
 *
 * @template-implements MethodInterface<true>
 */
final readonly class AnswerCallbackQuery implements MethodInterface
{
    public function __construct(
        private string $callbackQueryId,
        private ?string $text = null,
        private ?bool $showAlert = null,
        private ?string $url = null,
        private ?int $cacheTime = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerCallbackQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'callback_query_id' => $this->callbackQueryId,
                'text' => $this->text,
                'show_alert' => $this->showAlert,
                'url' => $this->url,
                'cache_time' => $this->cacheTime,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
