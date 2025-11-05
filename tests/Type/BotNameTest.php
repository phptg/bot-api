<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotName;

use function PHPUnit\Framework\assertSame;

final class BotNameTest extends TestCase
{
    public function testBase(): void
    {
        $name = new BotName('test');

        assertSame('test', $name->name);
    }

    public function testFromTelegramResult(): void
    {
        $name = (new ObjectFactory())->create([
            'name' => 'test',
        ], null, BotName::class);

        assertSame('test', $name->name);
    }
}
