<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockPhoto;
use Phptg\BotApi\Type\InputRichMessage;
use Phptg\BotApi\Type\InputRichMessageMedia;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputRichMessageTest extends TestCase
{
    public function testBase(): void
    {
        $message = new InputRichMessage();

        assertNull($message->html);
        assertNull($message->markdown);
        assertNull($message->isRtl);
        assertNull($message->skipEntityDetection);
        assertNull($message->media);
        assertNull($message->blocks);
        assertSame([], $message->toRequestArray());
    }

    public function testFull(): void
    {
        $mediaFile = new InputFile(null);
        $media = new InputRichMessageMedia('photo1', new InputMediaPhoto($mediaFile));
        $blockFile = new InputFile(null);
        $block = new InputRichBlockPhoto(new InputMediaPhoto($blockFile));
        $message = new InputRichMessage(
            html: '<b>Hello</b>',
            markdown: '**Hello**',
            isRtl: true,
            skipEntityDetection: true,
            media: [$media],
            blocks: [$block],
        );

        assertSame('<b>Hello</b>', $message->html);
        assertSame('**Hello**', $message->markdown);
        assertTrue($message->isRtl);
        assertTrue($message->skipEntityDetection);
        assertSame([$media], $message->media);
        assertSame([$block], $message->blocks);
        assertSame(
            [
                'blocks' => [$block->toRequestArray()],
                'html' => '<b>Hello</b>',
                'markdown' => '**Hello**',
                'media' => [$media->toRequestArray()],
                'is_rtl' => true,
                'skip_entity_detection' => true,
            ],
            $message->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
                'html' => '<b>Hello</b>',
                'markdown' => '**Hello**',
                'media' => [
                    [
                        'id' => 'photo1',
                        'media' => [
                            'type' => 'photo',
                            'media' => 'attach://file1',
                        ],
                    ],
                ],
                'is_rtl' => true,
                'skip_entity_detection' => true,
            ],
            $message->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $blockFile, 'file1' => $mediaFile], $fileCollector->get());
    }
}
