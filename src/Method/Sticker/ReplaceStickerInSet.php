<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Sticker\InputSticker;

/**
 * @see https://core.telegram.org/bots/api#replacestickerinset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class ReplaceStickerInSet implements MethodInterface
{
    public function __construct(
        private int $userId,
        private string $name,
        private string $oldSticker,
        private InputSticker $sticker,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'replaceStickerInSet';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $sticker = $this->sticker->toRequestArray($fileCollector);

        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'old_sticker' => $this->oldSticker,
            'sticker' => $sticker,
            ...$fileCollector->get(),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
