<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\ResponseParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ResponseParametersTest extends TestCase
{
    public function testBase(): void
    {
        $parameters = new ResponseParameters();

        assertNull($parameters->migrateToChatId);
        assertNull($parameters->retryAfter);
    }

    public function testFromDecodedBody()
    {
        $parameters = ResponseParameters::fromDecodedBody([
            'parameters' => [
                'migrate_to_chat_id' => 42,
                'retry_after' => 43,
            ],
        ]);

        assertSame(42, $parameters->migrateToChatId);
        assertSame(43, $parameters->retryAfter);
    }

    public function testFromDecodedBodyWithoutParameters(): void
    {
        $parameters = ResponseParameters::fromDecodedBody(['type' => 'parameters']);
        assertNull($parameters);
    }

    public function testFromDecodedBodyWithNonArrayParameters(): void
    {
        $parameters = ResponseParameters::fromDecodedBody(['parameters' => 42]);
        assertNull($parameters);
    }
}
