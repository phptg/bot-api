<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotDescription;

/**
 * @see https://core.telegram.org/bots/api#getmydescription
 *
 * @template-implements MethodInterface<BotDescription>
 */
final readonly class GetMyDescription implements MethodInterface
{
    public function __construct(
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyDescription';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'language_code' => $this->languageCode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(BotDescription::class);
    }
}
