<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\StrictTypeRequest;

use HttpSoft\Message\RequestTrait;
use LogicException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

use function is_array;
use function is_string;

final class StrictTypeRequest implements RequestInterface
{
    use RequestTrait {
        withHeader as protected traitWithHeader;
    }

    /**
     * @param StreamInterface|string|resource|null $body
     */
    public function __construct(
        string $method = 'GET',
        UriInterface|string $uri = '',
        array $headers = [],
        mixed $body = null,
        string $protocol = '1.1',
    ) {
        $this->init($method, $uri, $headers, $body, $protocol);
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        $this->checkValue($value);
        return $this->traitWithHeader($name, $value);
    }

    private function checkValue($value): void
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if (!is_string($item)) {
                    throw new LogicException('Invalid value.');
                }
            }
            return;
        }
        if (is_string($value)) {
            return;
        }
        throw new LogicException('Invalid value.');
    }
}
