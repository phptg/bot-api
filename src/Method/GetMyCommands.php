<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotCommand;
use Phptg\BotApi\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#getmycommands
 *
 * @template-implements MethodInterface<array<BotCommand>>
 */
final readonly class GetMyCommands implements MethodInterface
{
    public function __construct(
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyCommands';
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

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(BotCommand::class);
    }
}
