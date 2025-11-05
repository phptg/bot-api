<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestickerset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteStickerSet implements MethodInterface
{
    public function __construct(
        private string $name,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStickerSet';
    }

    public function getData(): array
    {
        return ['name' => $this->name];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
