<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaDocument;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaDocument('https://example.com/start.doc');

        assertSame('document', $inputMedia->getType());
        assertSame(
            [
                'type' => 'document',
                'media' => 'https://example.com/start.doc',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'document',
                'media' => 'https://example.com/start.doc',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $thumbnail = new InputFile((new StreamFactory())->createStream());
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaDocument(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            false,
        );

        assertSame('document', $inputMedia->getType());
        assertSame(
            [
                'type' => 'document',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'disable_content_type_detection' => false,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'document',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'disable_content_type_detection' => false,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $media,
                'file1' => $thumbnail,
            ],
            $fileCollector->get(),
        );
    }
}
