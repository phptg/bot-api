<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
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
        assertNull($message->media);
        assertNull($message->isRtl);
        assertNull($message->skipEntityDetection);
        assertSame([], $message->toRequestArray());
    }

    public function testFull(): void
    {
        $file = new InputFile(null);
        $media = new InputRichMessageMedia('photo1', new InputMediaPhoto($file));
        $message = new InputRichMessage(
            html: '<b>Hello</b>',
            markdown: '**Hello**',
            isRtl: true,
            skipEntityDetection: true,
            media: [$media],
        );

        assertSame('<b>Hello</b>', $message->html);
        assertSame('**Hello**', $message->markdown);
        assertSame([$media], $message->media);
        assertTrue($message->isRtl);
        assertTrue($message->skipEntityDetection);
        assertSame(
            [
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
                'html' => '<b>Hello</b>',
                'markdown' => '**Hello**',
                'media' => [
                    [
                        'id' => 'photo1',
                        'media' => [
                            'type' => 'photo',
                            'media' => 'attach://file0',
                        ],
                    ],
                ],
                'is_rtl' => true,
                'skip_entity_detection' => true,
            ],
            $message->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
