<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MenuButtonDefault;

use function PHPUnit\Framework\assertSame;

final class MenuButtonDefaultTest extends TestCase
{
    public function testBase(): void
    {
        $button = new MenuButtonDefault();

        assertSame('default', $button->getType());

        assertSame(['type' => 'default'], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'type' => 'default',
        ], null, MenuButtonDefault::class);

        assertSame('default', $button->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        (new ObjectFactory())->create('hello', null, MenuButtonDefault::class);
    }
}
