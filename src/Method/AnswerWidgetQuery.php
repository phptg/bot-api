<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#answerwidgetquery
 *
 * @template-implements MethodInterface<true>
 */
final readonly class AnswerWidgetQuery implements MethodInterface
{
    public function __construct(
        private string $widgetQueryId,
        private ?string $data = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerWidgetQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'widget_query_id' => $this->widgetQueryId,
                'data' => $this->data,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
