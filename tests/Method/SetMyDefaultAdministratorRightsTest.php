<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetMyDefaultAdministratorRights;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ChatAdministratorRights;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMyDefaultAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyDefaultAdministratorRights();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMyDefaultAdministratorRights', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $rights = new ChatAdministratorRights(true, false, true, true, true, true, true, true, true, true, true);
        $method = new SetMyDefaultAdministratorRights($rights, false);

        assertSame(
            [
                'rights' => $rights->toRequestArray(),
                'for_channels' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyDefaultAdministratorRights();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
