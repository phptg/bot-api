<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\AcceptedGiftTypes;

/**
 * @see https://core.telegram.org/bots/api#setbusinessaccountgiftsettings
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetBusinessAccountGiftSettings implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private bool $showGiftButton,
        private AcceptedGiftTypes $acceptedGiftTypes,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setBusinessAccountGiftSettings';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'show_gift_button' => $this->showGiftButton,
            'accepted_gift_types' => $this->acceptedGiftTypes->toRequestArray(),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
