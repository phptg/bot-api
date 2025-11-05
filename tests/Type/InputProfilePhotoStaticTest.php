<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputProfilePhoto;
use Phptg\BotApi\Type\InputProfilePhotoStatic;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputProfilePhotoStaticTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream());
        $type = new InputProfilePhotoStatic($photo);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('static', $type->getType());
        assertSame($photo, $type->photo);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'static',
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
