<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestory
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class DeleteStory implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $storyId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStory';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'story_id' => $this->storyId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
