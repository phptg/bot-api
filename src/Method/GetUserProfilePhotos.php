<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\UserProfilePhotos;

/**
 * @see https://core.telegram.org/bots/api#getuserprofilephotos
 *
 * @template-implements MethodInterface<UserProfilePhotos>
 */
final readonly class GetUserProfilePhotos implements MethodInterface
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
        return 'getUserProfilePhotos';
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
        return new ObjectValue(UserProfilePhotos::class);
    }
}
