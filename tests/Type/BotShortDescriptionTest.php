<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotShortDescription;

use function PHPUnit\Framework\assertSame;

final class BotShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $description = new BotShortDescription('test');

        assertSame('test', $description->shortDescription);
    }

    public function testFromTelegramResult(): void
    {
        $description = (new ObjectFactory())->create([
            'short_description' => 'test',
        ], null, BotShortDescription::class);

        assertSame('test', $description->shortDescription);
    }
}
