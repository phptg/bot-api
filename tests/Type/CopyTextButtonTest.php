<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\CopyTextButton;

use function PHPUnit\Framework\assertSame;

final class CopyTextButtonTest extends TestCase
{
    public function testBase(): void
    {
        $type = new CopyTextButton('test');

        assertSame('test', $type->text);
        assertSame(
            [
                'text' => 'test',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'text' => 'test',
            ],
            null,
            CopyTextButton::class,
        );

        assertSame('test', $type->text);
    }
}
