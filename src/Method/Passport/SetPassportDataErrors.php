<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Passport;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Passport\PassportElementError;

/**
 * @see https://core.telegram.org/bots/api#setpassportdataerrors
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetPassportDataErrors implements MethodInterface
{
    /**
     * @param PassportElementError[] $errors
     */
    public function __construct(
        private int $userId,
        private array $errors,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setPassportDataErrors';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'errors' => array_map(
                static fn(PassportElementError $error) => $error->toRequestArray(),
                $this->errors,
            ),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
