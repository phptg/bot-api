<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickersettitle
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetStickerSetTitle implements MethodInterface
{
    public function __construct(
        private string $name,
        private string $title,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerSetTitle';
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
