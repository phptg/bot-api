<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Inline\ChosenInlineResult;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChosenInlineResultTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'user1');
        $chosenInlineResult = new ChosenInlineResult(
            'x1',
            $user,
            'query1',
        );

        assertSame('x1', $chosenInlineResult->resultId);
        assertSame($user, $chosenInlineResult->from);
        assertSame('query1', $chosenInlineResult->query);
        assertNull($chosenInlineResult->location);
        assertNull($chosenInlineResult->inlineMessageId);
    }

    public function testFromTelegramResult(): void
    {
        $chosenInlineResult = (new ObjectFactory())->create([
            'result_id' => 'x1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'user1',
            ],
            'location' => [
                'latitude' => 1.2,
                'longitude' => 3.4,
            ],
            'inline_message_id' => 'm1',
            'query' => 'query1',
        ], null, ChosenInlineResult::class);

        assertSame('x1', $chosenInlineResult->resultId);

        assertSame(1, $chosenInlineResult->from->id);
        assertSame(false, $chosenInlineResult->from->isBot);
        assertSame('user1', $chosenInlineResult->from->firstName);

        assertSame(1.2, $chosenInlineResult->location->latitude);
        assertSame(3.4, $chosenInlineResult->location->longitude);

        assertSame('m1', $chosenInlineResult->inlineMessageId);
        assertSame('query1', $chosenInlineResult->query);
    }
}
