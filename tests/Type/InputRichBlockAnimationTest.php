<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaAnimation;
use Phptg\BotApi\Type\InputRichBlockAnimation;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new InputRichBlockAnimation(new InputMediaAnimation('animation_file_id_1'));

        assertSame('animation', $animation->getType());
        assertSame(
            ['type' => 'animation', 'animation' => ['type' => 'animation', 'media' => 'animation_file_id_1']],
            $animation->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $animation = new InputRichBlockAnimation(
            new InputMediaAnimation('animation_file_id_1'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'animation',
                'animation' => ['type' => 'animation', 'media' => 'animation_file_id_1'],
                'caption' => ['text' => 'caption'],
            ],
            $animation->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $animation = new InputRichBlockAnimation(new InputMediaAnimation($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'animation', 'animation' => ['type' => 'animation', 'media' => 'attach://file0']],
            $animation->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
