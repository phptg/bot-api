<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Poll;
use Phptg\BotApi\Type\PollOption;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class PollTest extends TestCase
{
    public function testBase(): void
    {
        $option = new PollOption('One', 12);
        $poll = new Poll(
            '12',
            'Why?',
            [$option],
            42,
            true,
            false,
            'regular',
            true,
        );

        assertSame('12', $poll->id);
        assertSame('Why?', $poll->question);
        assertSame([$option], $poll->options);
        assertSame(42, $poll->totalVoterCount);
        assertTrue($poll->isClosed);
        assertFalse($poll->isAnonymous);
        assertSame('regular', $poll->type);
        assertTrue($poll->allowsMultipleAnswers);
        assertNull($poll->correctOptionId);
        assertNull($poll->explanation);
        assertNull($poll->explanationEntities);
        assertNull($poll->openPeriod);
        assertNull($poll->closeDate);
    }

    public function testFromTelegramResult(): void
    {
        $poll = (new ObjectFactory())->create([
            'id' => '12',
            'question' => 'Why?',
            'options' => [
                ['text' => 'One', 'voter_count' => 12],
            ],
            'total_voter_count' => 42,
            'is_closed' => true,
            'is_anonymous' => false,
            'type' => 'regular',
            'allows_multiple_answers' => true,
            'question_entities' => [
                [
                    'offset' => 0,
                    'length' => 35,
                    'type' => 'bold',
                ],
            ],
            'correct_option_id' => 23,
            'explanation' => 'Because',
            'explanation_entities' => [
                [
                    'offset' => 0,
                    'length' => 31,
                    'type' => 'bold',
                ],
            ],
            'open_period' => 123,
            'close_date' => 456,
        ], null, Poll::class);

        assertSame('12', $poll->id);
        assertSame('Why?', $poll->question);

        assertCount(1, $poll->options);
        assertSame('One', $poll->options[0]->text);

        assertSame(42, $poll->totalVoterCount);
        assertTrue($poll->isClosed);
        assertFalse($poll->isAnonymous);
        assertSame('regular', $poll->type);
        assertTrue($poll->allowsMultipleAnswers);

        assertCount(1, $poll->questionEntities);
        assertSame(35, $poll->questionEntities[0]->length);

        assertSame(23, $poll->correctOptionId);
        assertSame('Because', $poll->explanation);

        assertCount(1, $poll->explanationEntities);
        assertSame(31, $poll->explanationEntities[0]->length);

        assertSame(123, $poll->openPeriod);
        assertSame(456, $poll->closeDate);
    }
}
