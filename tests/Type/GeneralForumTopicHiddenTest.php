<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GeneralForumTopicHidden;

use function PHPUnit\Framework\assertSame;

final class GeneralForumTopicHiddenTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new GeneralForumTopicHidden()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GeneralForumTopicHidden::class);
        $this->expectNotToPerformAssertions();
    }
}
