<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetUserEmojiStatus;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetUserEmojiStatusTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetUserEmojiStatus(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setUserEmojiStatus', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new SetUserEmojiStatus(9, 'test', $date);

        assertSame(
            [
                'user_id' => 9,
                'emoji_status_custom_emoji_id' => 'test',
                'emoji_status_expiration_date' => $date->getTimestamp(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetUserEmojiStatus(1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
