<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#deletemycommands
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteMyCommands implements MethodInterface
{
    public function __construct(
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMyCommands';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'scope' => $this->scope?->toRequestArray(),
                'language_code' => $this->languageCode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
