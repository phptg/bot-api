<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\DeleteStory;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteStoryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStory('bcid1', 123);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'story_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStory('business_connection_id', 123);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
