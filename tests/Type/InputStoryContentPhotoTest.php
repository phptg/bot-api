<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputStoryContent;
use Phptg\BotApi\Type\InputStoryContentPhoto;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputStoryContentPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile(null);
        $type = new InputStoryContentPhoto($photo);

        assertInstanceOf(InputStoryContent::class, $type);
        assertSame('photo', $type->getType());
        assertSame($photo, $type->photo);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'photo',
                'photo' => 'attach://file0',
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $photo,
            ],
            $fileCollector->get(),
        );
    }
}
