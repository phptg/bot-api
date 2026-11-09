<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#editsharedwidgetdata
 *
 * @template-implements MethodInterface<true>
 */
final readonly class EditSharedWidgetData implements MethodInterface
{
    public function __construct(
        private string $widgetId,
        private string $publicData,
        private ?int $cacheTime = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editSharedWidgetData';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'widget_id' => $this->widgetId,
                'public_data' => $this->publicData,
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
