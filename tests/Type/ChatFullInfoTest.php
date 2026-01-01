<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\AcceptedGiftTypes;
use Phptg\BotApi\Type\Birthdate;
use Phptg\BotApi\Type\BusinessIntro;
use Phptg\BotApi\Type\BusinessLocation;
use Phptg\BotApi\Type\BusinessOpeningHours;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\ChatFullInfo;
use Phptg\BotApi\Type\ChatLocation;
use Phptg\BotApi\Type\ChatPermissions;
use Phptg\BotApi\Type\ChatPhoto;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\ReactionTypeCustomEmoji;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatFullInfoTest extends TestCase
{
    public function testBase(): void
    {
        $info = new ChatFullInfo(23, 'private', 0x123456, 5);

        assertSame(23, $info->id);
        assertSame('private', $info->type);
        assertSame(0x123456, $info->accentColorId);
        assertSame(5, $info->maxReactionCount);
        assertNull($info->title);
        assertNull($info->username);
        assertNull($info->firstName);
        assertNull($info->lastName);
        assertNull($info->isForum);
        assertNull($info->photo);
        assertNull($info->activeUsernames);
        assertNull($info->birthdate);
        assertNull($info->businessIntro);
        assertNull($info->businessLocation);
        assertNull($info->businessOpeningHours);
        assertNull($info->personalChat);
        assertNull($info->availableReactions);
        assertNull($info->backgroundCustomEmojiId);
        assertNull($info->profileAccentColorId);
        assertNull($info->profileBackgroundCustomEmojiId);
        assertNull($info->emojiStatusCustomEmojiId);
        assertNull($info->emojiStatusExpirationDate);
        assertNull($info->bio);
        assertNull($info->hasPrivateForwards);
        assertNull($info->hasRestrictedVoiceAndVideoMessages);
        assertNull($info->joinToSendMessages);
        assertNull($info->joinByRequest);
        assertNull($info->description);
        assertNull($info->inviteLink);
        assertNull($info->pinnedMessage);
        assertNull($info->permissions);
        assertNull($info->slowModeDelay);
        assertNull($info->unrestrictBoostCount);
        assertNull($info->messageAutoDeleteTime);
        assertNull($info->hasAggressiveAntiSpamEnabled);
        assertNull($info->hasHiddenMembers);
        assertNull($info->hasProtectedContent);
        assertNull($info->hasVisibleHistory);
        assertNull($info->stickerSetName);
        assertNull($info->canSetStickerSet);
        assertNull($info->customEmojiStickerSetName);
        assertNull($info->linkedChatId);
        assertNull($info->location);
        assertNull($info->canSendPaidMedia);
        assertNull($info->acceptedGiftTypes);
        assertNull($info->isDirectMessages);
        assertNull($info->parentChat);
    }

    public function testFromTelegramResult(): void
    {
        $info = (new ObjectFactory())->create([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
            'title' => 'Title',
            'username' => 'Bat',
            'first_name' => 'Bruce',
            'last_name' => 'Willy',
            'is_forum' => true,
            'is_direct_messages' => true,
            'photo' => [
                'small_file_id' => '123',
                'small_file_unique_id' => 'u123',
                'big_file_id' => '456',
                'big_file_unique_id' => 'u456',
            ],
            'active_usernames' => ['aka1', 'aka2'],
            'birthdate' => [
                'day' => 1,
                'month' => 2,
            ],
            'business_intro' => [
                'title' => 'My Business',
            ],
            'business_location' => [
                'address' => 'My Address',
            ],
            'business_opening_hours' => [
                'time_zone_name' => 'Europe/Moscow',
                'opening_hours' => [
                    [
                        'opening_minute' => 10,
                        'closing_minute' => 20,
                    ],
                ],
            ],
            'personal_chat' => [
                'id' => 42,
                'type' => 'private',
            ],
            'parent_chat' => [
                'id' => 987,
                'type' => 'channel',
            ],
            'available_reactions' => [
                [
                    'type' => 'custom_emoji',
                    'custom_emoji_id' => '=)',
                ],
            ],
            'background_custom_emoji_id' => 'bge1',
            'profile_accent_color_id' => 0x654321,
            'profile_background_custom_emoji_id' => 'bge2',
            'emoji_status_custom_emoji_id' => 'bge3',
            'emoji_status_expiration_date' => 1717501903,
            'bio' => 'My Bio',
            'has_private_forwards' => true,
            'has_restricted_voice_and_video_messages' => true,
            'join_to_send_messages' => true,
            'join_by_request' => true,
            'description' => 'My Description',
            'invite_link' => 'https://t.me/joinchat/123',
            'pinned_message' => [
                'message_id' => 123,
                'date' => 1717501903,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
            ],
            'permissions' => [
                'can_send_messages' => true,
            ],
            'accepted_gift_types' =>  [
                'unlimited_gifts' => true,
                'limited_gifts' => false,
                'unique_gifts' => true,
                'premium_subscription' => false,
                'gifts_from_channels' => true,
            ],
            'slow_mode_delay' => 5,
            'unrestrict_boost_count' => 10,
            'message_auto_delete_time' => 111,
            'has_aggressive_anti_spam_enabled' => true,
            'has_hidden_members' => true,
            'has_protected_content' => true,
            'has_visible_history' => true,
            'sticker_set_name' => 'MyStickerSet',
            'can_set_sticker_set' => true,
            'custom_emoji_sticker_set_name' => 'MyCustomEmojiStickerSet',
            'linked_chat_id' => 42,
            'location' => [
                'location' => [
                    'latitude' => 55.7558,
                    'longitude' => 37.6176,
                ],
                'address' => 'Moscow',
            ],
            'can_send_paid_media' => true,
        ], null, ChatFullInfo::class);

        assertSame(23, $info->id);
        assertSame('private', $info->type);
        assertSame(0x123456, $info->accentColorId);
        assertSame(5, $info->maxReactionCount);
        assertSame('Title', $info->title);
        assertSame('Bat', $info->username);
        assertSame('Bruce', $info->firstName);
        assertSame('Willy', $info->lastName);
        assertTrue($info->isForum);

        assertInstanceOf(ChatPhoto::class, $info->photo);
        assertSame('123', $info->photo->smallFileId);

        assertSame(['aka1', 'aka2'], $info->activeUsernames);

        assertInstanceOf(Birthdate::class, $info->birthdate);
        assertSame(1, $info->birthdate->day);

        assertInstanceOf(BusinessIntro::class, $info->businessIntro);
        assertSame('My Business', $info->businessIntro->title);

        assertInstanceOf(BusinessLocation::class, $info->businessLocation);
        assertSame('My Address', $info->businessLocation->address);

        assertInstanceOf(BusinessOpeningHours::class, $info->businessOpeningHours);
        assertSame('Europe/Moscow', $info->businessOpeningHours->timeZoneName);

        assertInstanceOf(Chat::class, $info->personalChat);
        assertSame(42, $info->personalChat->id);

        assertIsArray($info->availableReactions);
        assertCount(1, $info->availableReactions);
        assertInstanceOf(ReactionTypeCustomEmoji::class, $info->availableReactions[0]);
        assertSame('=)', $info->availableReactions[0]->customEmojiId);

        assertSame('bge1', $info->backgroundCustomEmojiId);
        assertSame(0x654321, $info->profileAccentColorId);
        assertSame('bge2', $info->profileBackgroundCustomEmojiId);
        assertSame('bge3', $info->emojiStatusCustomEmojiId);
        assertSame(1717501903, $info->emojiStatusExpirationDate?->getTimestamp());
        assertSame('My Bio', $info->bio);
        assertTrue($info->hasPrivateForwards);
        assertTrue($info->hasRestrictedVoiceAndVideoMessages);
        assertTrue($info->joinToSendMessages);
        assertTrue($info->joinByRequest);
        assertSame('My Description', $info->description);
        assertSame('https://t.me/joinchat/123', $info->inviteLink);

        assertInstanceOf(Message::class, $info->pinnedMessage);
        assertSame(123, $info->pinnedMessage->messageId);

        assertInstanceOf(ChatPermissions::class, $info->permissions);
        assertTrue($info->permissions->canSendMessages);

        assertSame(5, $info->slowModeDelay);
        assertSame(10, $info->unrestrictBoostCount);
        assertSame(111, $info->messageAutoDeleteTime);
        assertTrue($info->hasAggressiveAntiSpamEnabled);
        assertTrue($info->hasHiddenMembers);
        assertTrue($info->hasProtectedContent);
        assertTrue($info->hasVisibleHistory);
        assertSame('MyStickerSet', $info->stickerSetName);
        assertTrue($info->canSetStickerSet);
        assertSame('MyCustomEmojiStickerSet', $info->customEmojiStickerSetName);
        assertSame(42, $info->linkedChatId);

        assertInstanceOf(ChatLocation::class, $info->location);
        assertSame(55.7558, $info->location->location->latitude);

        assertTrue($info->canSendPaidMedia);
        assertInstanceOf(AcceptedGiftTypes::class, $info->acceptedGiftTypes);
        assertTrue($info->acceptedGiftTypes->unlimitedGifts);
        assertFalse($info->acceptedGiftTypes->limitedGifts);
        assertTrue($info->acceptedGiftTypes->uniqueGifts);
        assertFalse($info->acceptedGiftTypes->premiumSubscription);
        assertTrue($info->isDirectMessages);
        assertSame(987, $info->parentChat?->id);
    }
}
