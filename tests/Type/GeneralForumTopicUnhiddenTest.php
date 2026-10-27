<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GeneralForumTopicUnhidden;

use function PHPUnit\Framework\assertSame;

final class GeneralForumTopicUnhiddenTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new GeneralForumTopicUnhidden()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GeneralForumTopicUnhidden::class);
        $this->expectNotToPerformAssertions();
    }
}
