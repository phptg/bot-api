<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Sticker\Gifts;

/**
 * @see https://core.telegram.org/bots/api#getavailablegifts
 *
 * @template-implements MethodInterface<Gifts>
 */
final readonly class GetAvailableGifts implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getAvailableGifts';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Gifts::class);
    }
}
