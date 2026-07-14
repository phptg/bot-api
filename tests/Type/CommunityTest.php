<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Community;

use function PHPUnit\Framework\assertSame;

final class CommunityTest extends TestCase
{
    public function testBase(): void
    {
        $community = new Community(123, 'My Community');

        assertSame(123, $community->id);
        assertSame('My Community', $community->name);
    }

    public function testFromTelegramResult(): void
    {
        $community = (new ObjectFactory())->create([
            'id' => 123,
            'name' => 'My Community',
        ], null, Community::class);

        assertSame(123, $community->id);
        assertSame('My Community', $community->name);
    }
}
