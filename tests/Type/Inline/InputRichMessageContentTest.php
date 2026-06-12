<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputRichMessageContent;
use Phptg\BotApi\Type\InputRichMessage;

use function PHPUnit\Framework\assertSame;

final class InputRichMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $richMessage = new InputRichMessage(html: '<b>Hello</b>');
        $content = new InputRichMessageContent($richMessage);

        assertSame($richMessage, $content->richMessage);
        assertSame(
            [
                'rich_message' => ['html' => '<b>Hello</b>'],
            ],
            $content->toRequestArray(),
        );
    }
}
