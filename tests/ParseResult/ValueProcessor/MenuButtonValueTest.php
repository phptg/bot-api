<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\MenuButtonValue;
use Phptg\BotApi\Type\MenuButtonCommands;
use Phptg\BotApi\Type\MenuButtonDefault;
use Phptg\BotApi\Type\MenuButtonWebApp;

use function PHPUnit\Framework\assertInstanceOf;

final class MenuButtonValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                MenuButtonCommands::class,
                [
                    'type' => 'commands',
                ],
            ],
            [
                MenuButtonWebApp::class,
                [
                    'type' => 'web_app',
                    'text' => 'test',
                    'web_app' => [
                        'url' => 'https://example.com',
                    ],
                ],
            ],
            [
                MenuButtonDefault::class,
                [
                    'type' => 'default',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MenuButtonValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MenuButtonValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown menu button type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
