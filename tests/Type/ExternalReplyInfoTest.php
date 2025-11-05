<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Checklist;
use Phptg\BotApi\Type\ChecklistTask;
use Phptg\BotApi\Type\ExternalReplyInfo;
use Phptg\BotApi\Type\MessageOriginUser;
use Phptg\BotApi\Type\PaidMediaPhoto;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ExternalReplyInfoTest extends TestCase
{
    public function testBase(): void
    {
        $origin = new MessageOriginUser(new DateTimeImmutable(), new User(123, false, 'Vjik'));
        $externalReplyInfo = new ExternalReplyInfo($origin);

        assertSame($origin, $externalReplyInfo->origin);
        assertNull($externalReplyInfo->chat);
        assertNull($externalReplyInfo->messageId);
        assertNull($externalReplyInfo->linkPreviewOptions);
        assertNull($externalReplyInfo->animation);
        assertNull($externalReplyInfo->audio);
        assertNull($externalReplyInfo->document);
        assertNull($externalReplyInfo->photo);
        assertNull($externalReplyInfo->sticker);
        assertNull($externalReplyInfo->story);
        assertNull($externalReplyInfo->video);
        assertNull($externalReplyInfo->videoNote);
        assertNull($externalReplyInfo->voice);
        assertNull($externalReplyInfo->hasMediaSpoiler);
        assertNull($externalReplyInfo->contact);
        assertNull($externalReplyInfo->dice);
        assertNull($externalReplyInfo->game);
        assertNull($externalReplyInfo->giveaway);
        assertNull($externalReplyInfo->giveawayWinners);
        assertNull($externalReplyInfo->invoice);
        assertNull($externalReplyInfo->location);
        assertNull($externalReplyInfo->poll);
        assertNull($externalReplyInfo->venue);
        assertNull($externalReplyInfo->paidMedia);
        assertNull($externalReplyInfo->checklist);
    }

    public function testFromTelegramResult(): void
    {
        $externalReplyInfo = (new ObjectFactory())->create([
            'origin' => [
                'type' => 'user',
                'date' => 1620000000,
                'sender_user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
            ],
            'chat' => [
                'id' => 44,
                'type' => 'private',
            ],
            'message_id' => 97,
            'link_preview_options' => [
                'url' => 'https://example.com/hello',
            ],
            'animation' => [
                'file_id' => 'f1',
                'file_unique_id' => 'fu1',
                'width' => 320,
                'height' => 240,
                'duration' => 15,
            ],
            'audio' => [
                'file_id' => 'f2',
                'file_unique_id' => 'fu2',
                'duration' => 15,
            ],
            'document' => [
                'file_id' => 'f3',
                'file_unique_id' => 'fu3',
            ],
            'photo' => [
                [
                    'file_id' => 'f4',
                    'file_unique_id' => 'fu4',
                    'width' => 320,
                    'height' => 240,
                ],
            ],
            'sticker' => [
                'file_id' => 'f5',
                'file_unique_id' => 'fu5',
                'type' => 'regular',
                'width' => 320,
                'height' => 240,
                'is_animated' => true,
                'is_video' => false,
            ],
            'story' => [
                'chat' => [
                    'id' => 45,
                    'type' => 'private',
                ],
                'id' => 99,
            ],
            'video' => [
                'file_id' => 'f6',
                'file_unique_id' => 'fu6',
                'width' => 320,
                'height' => 240,
                'duration' => 15,
            ],
            'video_note' => [
                'file_id' => 'f7',
                'file_unique_id' => 'fu7',
                'length' => 5,
                'duration' => 15,
            ],
            'voice' => [
                'file_id' => 'f8',
                'file_unique_id' => 'fu8',
                'duration' => 15,
            ],
            'has_media_spoiler' => true,
            'contact' => [
                'phone_number' => '+1234567890',
                'first_name' => 'Vjik',
            ],
            'dice' => [
                'emoji' => '🎲',
                'value' => 6,
            ],
            'game' => [
                'title' => 'Game',
                'description' => 'Description',
                'photo' => [],
            ],
            'giveaway' => [
                'chats' => [],
                'winners_selection_date' => 1620000000,
                'winner_count' => 35,
            ],
            'giveaway_winners' => [
                'chat' => [
                    'id' => 46,
                    'type' => 'private',
                ],
                'giveaway_message_id' => 3461,
                'winners_selection_date' => 1620000002,
                'winner_count' => 0,
                'winners' => [],
            ],
            'invoice' => [
                'title' => 'Invoice',
                'description' => 'Description',
                'start_parameter' => 'start',
                'currency' => 'USD',
                'total_amount' => 101,
            ],
            'location' => [
                'latitude' => 55.7558,
                'longitude' => 37.6176,
            ],
            'poll' => [
                'id' => 'pid2354',
                'question' => 'Question',
                'options' => [],
                'total_voter_count' => 5,
                'is_closed' => true,
                'is_anonymous' => false,
                'type' => 'regular',
                'allows_multiple_answers' => true,
            ],
            'venue' => [
                'location' => [
                    'latitude' => 55.7558,
                    'longitude' => 37.6176,
                ],
                'title' => 'Venue1',
                'address' => 'Address',
            ],
            'paid_media' => [
                'star_count' => 1,
                'paid_media' => [
                    [
                        'type' => 'photo',
                        'photo' => [],
                    ],
                ],
            ],
            'checklist' => [
                'title' => 'My Checklist',
                'tasks' => [
                    ['id' => 1, 'text' => 'Task 1'],
                    ['id' => 2, 'text' => 'Task 2'],
                ],
            ],
        ], null, ExternalReplyInfo::class);

        assertInstanceOf(MessageOriginUser::class, $externalReplyInfo->origin);
        assertSame(123, $externalReplyInfo->origin->senderUser->id);

        assertSame(44, $externalReplyInfo->chat?->id);
        assertSame(97, $externalReplyInfo->messageId);
        assertSame('https://example.com/hello', $externalReplyInfo->linkPreviewOptions?->url);
        assertSame('f1', $externalReplyInfo->animation?->fileId);
        assertSame('f2', $externalReplyInfo->audio?->fileId);
        assertSame('f3', $externalReplyInfo->document?->fileId);

        assertCount(1, $externalReplyInfo->photo);
        assertSame('f4', $externalReplyInfo->photo[0]->fileId);

        assertSame('f5', $externalReplyInfo->sticker?->fileId);
        assertSame(99, $externalReplyInfo->story?->id);
        assertSame('f6', $externalReplyInfo->video?->fileId);
        assertSame('f7', $externalReplyInfo->videoNote?->fileId);
        assertSame('f8', $externalReplyInfo->voice?->fileId);
        assertTrue($externalReplyInfo->hasMediaSpoiler);
        assertSame('+1234567890', $externalReplyInfo->contact?->phoneNumber);
        assertSame('🎲', $externalReplyInfo->dice?->emoji);
        assertSame('Game', $externalReplyInfo->game?->title);
        assertSame(35, $externalReplyInfo->giveaway?->winnerCount);
        assertSame(3461, $externalReplyInfo->giveawayWinners?->giveawayMessageId);
        assertSame(101, $externalReplyInfo->invoice?->totalAmount);
        assertSame(55.7558, $externalReplyInfo->location?->latitude);
        assertSame('pid2354', $externalReplyInfo->poll?->id);
        assertSame('Venue1', $externalReplyInfo->venue?->title);
        assertSame(1, $externalReplyInfo->paidMedia?->starCount);
        assertEquals([new PaidMediaPhoto([])], $externalReplyInfo->paidMedia?->paidMedia);
        assertEquals(
            new Checklist(
                'My Checklist',
                [new ChecklistTask(1, 'Task 1'), new ChecklistTask(2, 'Task 2')],
            ),
            $externalReplyInfo->checklist,
        );
    }
}
