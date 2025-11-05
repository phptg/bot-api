<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#setstickersetthumbnail
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetStickerSetThumbnail implements MethodInterface
{
    public function __construct(
        private string $name,
        private int $userId,
        private string $format,
        private InputFile|string|null $thumbnail = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerSetThumbnail';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'name' => $this->name,
                'user_id' => $this->userId,
                'thumbnail' => $this->thumbnail,
                'format' => $this->format,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
