<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestickerfromset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteStickerFromSet implements MethodInterface
{
    public function __construct(
        private string $sticker,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStickerFromSet';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
