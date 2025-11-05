<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotDescription;

use function PHPUnit\Framework\assertSame;

final class BotDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $description = new BotDescription('test');

        assertSame('test', $description->description);
    }

    public function testFromTelegramResult(): void
    {
        $description = (new ObjectFactory())->create([
            'description' => 'test',
        ], null, BotDescription::class);

        assertSame('test', $description->description);
    }
}
