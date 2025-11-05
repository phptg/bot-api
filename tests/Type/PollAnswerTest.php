<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PollAnswer;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PollAnswerTest extends TestCase
{
    public function testBase(): void
    {
        $answer = new PollAnswer('sadg', [2, 4]);

        assertSame('sadg', $answer->pollId);
        assertSame([2, 4], $answer->optionIds);
        assertNull($answer->voterChat);
        assertNull($answer->user);
    }

    public function testFromTelegramResult(): void
    {
        $answer = (new ObjectFactory())->create([
            'poll_id' => 'sadg',
            'option_ids' => [2, 4],
            'voter_chat' => [
                'id' => 42,
                'type' => 'private',
            ],
            'user' => [
                'id' => 43,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, PollAnswer::class);

        assertSame('sadg', $answer->pollId);
        assertSame([2, 4], $answer->optionIds);
        assertSame(42, $answer->voterChat?->id);
        assertSame(43, $answer->user?->id);
    }
}
