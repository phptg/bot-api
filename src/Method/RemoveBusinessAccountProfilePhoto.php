<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#removebusinessaccountprofilephoto
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class RemoveBusinessAccountProfilePhoto implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?bool $isPublic = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'removeBusinessAccountProfilePhoto';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'is_public' => $this->isPublic,
            ],
            static fn($value) => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
