<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#setbusinessaccountusername
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetBusinessAccountUsername implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?string $username = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setBusinessAccountUsername';
    }

    public function getData(): array
    {
        $data = [
            'business_connection_id' => $this->businessConnectionId,
        ];

        if ($this->username !== null) {
            $data['username'] = $this->username;
        }

        return $data;
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
