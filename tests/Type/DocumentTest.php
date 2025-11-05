<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Document;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class DocumentTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('x1', 'xf1');

        assertSame('x1', $document->fileId);
        assertSame('xf1', $document->fileUniqueId);
        assertNull($document->thumbnail);
        assertNull($document->fileName);
        assertNull($document->mimeType);
        assertNull($document->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $document = (new ObjectFactory())->create([
            'file_id' => 'x1',
            'file_unique_id' => 'xf1',
            'thumbnail' => [
                'file_id' => 'tf1',
                'file_unique_id' => 'tfu1',
                'width' => 1,
                'height' => 2,
            ],
            'file_name' => 'face.png',
            'mime_type' => 'image/png',
            'file_size' => 123,
        ], null, Document::class);

        assertSame('x1', $document->fileId);
        assertSame('xf1', $document->fileUniqueId);

        assertInstanceOf(PhotoSize::class, $document->thumbnail);
        assertSame('tf1', $document->thumbnail->fileId);
        assertSame('tfu1', $document->thumbnail->fileUniqueId);

        assertSame('face.png', $document->fileName);
        assertSame('image/png', $document->mimeType);
        assertSame(123, $document->fileSize);
    }
}
