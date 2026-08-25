<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaDocument;
use Phptg\BotApi\Type\InputRichBlockDocument;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $document = new InputRichBlockDocument(new InputMediaDocument('document_file_id_1'));

        assertSame('document', $document->getType());
        assertSame(
            [
                'type' => 'document',
                'document' => ['type' => 'document', 'media' => 'document_file_id_1'],
            ],
            $document->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $document = new InputRichBlockDocument(
            new InputMediaDocument('document_file_id_1'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'document',
                'document' => ['type' => 'document', 'media' => 'document_file_id_1'],
                'caption' => ['text' => 'caption'],
            ],
            $document->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $document = new InputRichBlockDocument(new InputMediaDocument($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'document', 'document' => ['type' => 'document', 'media' => 'attach://file0']],
            $document->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
