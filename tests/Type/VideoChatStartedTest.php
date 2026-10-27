<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoChatStarted;

use function PHPUnit\Framework\assertSame;

final class VideoChatStartedTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new VideoChatStarted()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, VideoChatStarted::class);
        $this->expectNotToPerformAssertions();
    }
}
