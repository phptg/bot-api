<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\EphemeralMessageParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EphemeralMessageParametersTest extends TestCase
{
    public function testBase(): void
    {
        $parameters = new EphemeralMessageParameters(1);

        assertSame(1, $parameters->receiverUserId);
        assertNull($parameters->callbackQueryId);
        assertNull($parameters->replaceCallbackQueryMessage);

        assertSame(
            [
                'receiver_user_id' => 1,
            ],
            $parameters->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $parameters = new EphemeralMessageParameters(1, 'query-id', true);

        assertSame(1, $parameters->receiverUserId);
        assertSame('query-id', $parameters->callbackQueryId);
        assertTrue($parameters->replaceCallbackQueryMessage);

        assertSame(
            [
                'receiver_user_id' => 1,
                'callback_query_id' => 'query-id',
                'replace_callback_query_message' => true,
            ],
            $parameters->toRequestArray(),
        );
    }
}
