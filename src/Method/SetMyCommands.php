<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\BotCommand;
use Phptg\BotApi\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#setmycommands
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetMyCommands implements MethodInterface
{
    /**
     * @param BotCommand[] $commands
     */
    public function __construct(
        private array $commands,
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyCommands';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'commands' => array_map(
                    static fn(BotCommand $botCommand) => $botCommand->toRequestArray(),
                    $this->commands,
                ),
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
