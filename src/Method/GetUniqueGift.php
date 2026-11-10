<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\UniqueGift;

/**
 * @see https://core.telegram.org/bots/api#getuniquegift
 *
 * @template-implements MethodInterface<UniqueGift>
 *
 * @api
 */
final readonly class GetUniqueGift implements MethodInterface
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
        return 'getUniqueGift';
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
     * @return ObjectValue<UniqueGift>
     */
    public function getResultType(): ObjectValue
    {
        return new ObjectValue(UniqueGift::class);
    }
}
