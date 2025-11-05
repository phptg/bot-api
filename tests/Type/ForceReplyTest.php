<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\ForceReply;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ForceReplyTest extends TestCase
{
    public function testBase(): void
    {
        $forceReply = new ForceReply();

        assertNull($forceReply->inputFieldPlaceholder);
        assertNull($forceReply->selective);

        assertSame(
            [
                'force_reply' => true,
            ],
            $forceReply->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $forceReply = new ForceReply('test', false);

        assertSame('test', $forceReply->inputFieldPlaceholder);
        assertFalse($forceReply->selective);

        assertSame(
            [
                'force_reply' => true,
                'input_field_placeholder' => 'test',
                'selective' => false,
            ],
            $forceReply->toRequestArray(),
        );
    }
}
