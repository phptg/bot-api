<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputMediaLink;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaLinkTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaLink('https://example.com');

        assertSame('link', $inputMedia->getType());
        assertSame(
            [
                'type' => 'link',
                'url' => 'https://example.com',
            ],
            $inputMedia->toRequestArray(),
        );
    }

    public function testBaseWithFileCollector(): void
    {
        $inputMedia = new InputMediaLink('https://example.com');

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'link',
                'url' => 'https://example.com',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }
}
