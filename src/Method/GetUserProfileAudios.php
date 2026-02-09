<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\UserProfileAudios;

/**
 * @see https://core.telegram.org/bots/api#getuserprofileaudios
 *
 * @template-implements MethodInterface<UserProfileAudios>
 */
final readonly class GetUserProfileAudios implements MethodInterface
{
    public function __construct(
        private int $userId,
        private ?int $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUserProfileAudios';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'offset' => $this->offset,
                'limit' => $this->limit,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(UserProfileAudios::class);
    }
}
