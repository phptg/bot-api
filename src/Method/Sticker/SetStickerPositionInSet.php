<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickerpositioninset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetStickerPositionInSet implements MethodInterface
{
    public function __construct(
        private string $sticker,
        private int $position,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerPositionInSet';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
            'position' => $this->position,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
