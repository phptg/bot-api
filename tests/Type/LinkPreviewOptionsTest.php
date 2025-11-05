<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\LinkPreviewOptions;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class LinkPreviewOptionsTest extends TestCase
{
    public function testBase(): void
    {
        $options = new LinkPreviewOptions();

        assertNull($options->isDisabled);
        assertNull($options->url);
        assertNull($options->preferSmallMedia);
        assertNull($options->preferLargeMedia);
        assertNull($options->showAboveText);

        assertSame([], $options->toRequestArray());
    }

    public function testFilled(): void
    {
        $options = new LinkPreviewOptions(true, 'https://example.com/', true, false, true);

        assertTrue($options->isDisabled);
        assertSame('https://example.com/', $options->url);
        assertTrue($options->preferSmallMedia);
        assertFalse($options->preferLargeMedia);
        assertTrue($options->showAboveText);

        assertSame(
            [
                'is_disabled' => true,
                'url' => 'https://example.com/',
                'prefer_small_media' => true,
                'prefer_large_media' => false,
                'show_above_text' => true,
            ],
            $options->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $options = (new ObjectFactory())->create([
            'is_disabled' => true,
            'url' => 'https://example.com/',
            'prefer_small_media' => true,
            'prefer_large_media' => false,
            'show_above_text' => true,
        ], null, LinkPreviewOptions::class);

        assertTrue($options->isDisabled);
        assertSame('https://example.com/', $options->url);
        assertTrue($options->preferSmallMedia);
        assertFalse($options->preferLargeMedia);
        assertTrue($options->showAboveText);
    }
}
