<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#removeuserverification
 *
 * @template-implements MethodInterface<true>
 */
final readonly class RemoveUserVerification implements MethodInterface
{
    public function __construct(
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'removeUserVerification';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
