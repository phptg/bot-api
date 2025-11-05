<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RemoveBusinessAccountProfilePhoto;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveBusinessAccountProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection123');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeBusinessAccountProfilePhoto', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection123',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection123', true);

        assertSame(
            [
                'business_connection_id' => 'connection123',
                'is_public' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection1');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
