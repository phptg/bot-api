<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Animation;
use Phptg\BotApi\Type\Game\Game;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class GameTest extends TestCase
{
    public function testBase(): void
    {
        $game = new Game(
            'My Game',
            'The best game.',
            [
                new PhotoSize('id1', 'unique-id1', 100, 200),
            ],
        );

        assertSame('My Game', $game->title);
        assertSame('The best game.', $game->description);

        assertCount(1, $game->photo);
        assertSame('id1', $game->photo[0]->fileId);
        assertSame('unique-id1', $game->photo[0]->fileUniqueId);
        assertSame(100, $game->photo[0]->width);
        assertSame(200, $game->photo[0]->height);
    }

    public function testFromTelegramResult(): void
    {
        $game = (new ObjectFactory())->create([
            'title' => 'My Game',
            'description' => 'The best game.',
            'photo' => [
                [
                    'file_id' => 'id1',
                    'file_unique_id' => 'unique-id1',
                    'width' => 100,
                    'height' => 200,
                ],
            ],
            'text' => 'test text',
            'text_entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 4,
                ],
            ],
            'animation' => [
                'file_id' => 'id2',
                'file_unique_id' => 'unique-id2',
                'width' => 300,
                'height' => 400,
                'duration' => 12,
            ],
        ], null, Game::class);

        assertSame('My Game', $game->title);
        assertSame('The best game.', $game->description);

        assertCount(1, $game->photo);
        assertSame('id1', $game->photo[0]->fileId);
        assertSame('unique-id1', $game->photo[0]->fileUniqueId);
        assertSame(100, $game->photo[0]->width);
        assertSame(200, $game->photo[0]->height);

        assertSame('test text', $game->text);

        assertIsArray($game->textEntities);
        assertCount(1, $game->textEntities);
        assertSame('bold', $game->textEntities[0]->type);
        assertSame(0, $game->textEntities[0]->offset);
        assertSame(4, $game->textEntities[0]->length);

        assertInstanceOf(Animation::class, $game->animation);
        assertSame('id2', $game->animation->fileId);
        assertSame('unique-id2', $game->animation->fileUniqueId);
        assertSame(300, $game->animation->width);
        assertSame(400, $game->animation->height);
        assertSame(12, $game->animation->duration);
    }
}
