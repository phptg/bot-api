<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickerkeywords
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetStickerKeywords implements MethodInterface
{
    /**
     * @param string[]|null $keywords
     */
    public function __construct(
        private string $sticker,
        private ?array $keywords = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerKeywords';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'sticker' => $this->sticker,
                'keywords' => $this->keywords,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
