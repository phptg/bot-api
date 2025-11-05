<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#convertgifttostars
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class ConvertGiftToStars implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private string $ownedGiftId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'convertGiftToStars';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'owned_gift_id' => $this->ownedGiftId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
