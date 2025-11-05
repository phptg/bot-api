<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#setbusinessaccountname
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetBusinessAccountName implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private string $firstName,
        private ?string $lastName = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setBusinessAccountName';
    }

    public function getData(): array
    {
        $data = [
            'business_connection_id' => $this->businessConnectionId,
            'first_name' => $this->firstName,
        ];

        if ($this->lastName !== null) {
            $data['last_name'] = $this->lastName;
        }

        return $data;
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
