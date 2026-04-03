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
            false,
        );

        assertSame('12', $poll->id);
        assertSame('Why?', $poll->question);
        assertSame([$option], $poll->options);
        assertSame(42, $poll->totalVoterCount);
        assertTrue($poll->isClosed);
        assertFalse($poll->isAnonymous);
        assertSame('regular', $poll->type);
        assertTrue($poll->allowsMultipleAnswers);
        assertFalse($poll->allowsRevoting);
        assertNull($poll->correctOptionIds);
        assertNull($poll->explanation);
        assertNull($poll->explanationEntities);
        assertNull($poll->openPeriod);
        assertNull($poll->closeDate);
        assertNull($poll->description);
        assertNull($poll->descriptionEntities);
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
            'allows_revoting' => true,
            'question_entities' => [
                [
                    'offset' => 0,
                    'length' => 35,
                    'type' => 'bold',
                ],
            ],
            'correct_option_ids' => [0, 2],
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
            'description' => 'Poll description',
            'description_entities' => [
                [
                    'offset' => 0,
                    'length' => 4,
                    'type' => 'bold',
                ],
            ],
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
        assertTrue($poll->allowsRevoting);

        assertCount(1, $poll->questionEntities);
        assertSame(35, $poll->questionEntities[0]->length);

        assertSame([0, 2], $poll->correctOptionIds);
        assertSame('Because', $poll->explanation);

        assertCount(1, $poll->explanationEntities);
        assertSame(31, $poll->explanationEntities[0]->length);

        assertSame(123, $poll->openPeriod);
        assertSame(456, $poll->closeDate);
        assertSame('Poll description', $poll->description);
        assertCount(1, $poll->descriptionEntities);
        assertSame(4, $poll->descriptionEntities[0]->length);
    }
}
