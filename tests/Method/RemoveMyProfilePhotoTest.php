<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RemoveMyProfilePhoto;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveMyProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveMyProfilePhoto();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeMyProfilePhoto', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveMyProfilePhoto();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
