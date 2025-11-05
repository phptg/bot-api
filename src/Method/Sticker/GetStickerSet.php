<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Sticker\StickerSet;

/**
 * @see https://core.telegram.org/bots/api#getstickerset
 *
 * @template-implements MethodInterface<StickerSet>
 */
final readonly class GetStickerSet implements MethodInterface
{
    public function __construct(
        private string $name,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getStickerSet';
    }

    public function getData(): array
    {
        return ['name' => $this->name];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(StickerSet::class);
    }
}
