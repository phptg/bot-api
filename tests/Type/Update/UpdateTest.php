<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Update;

use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Throwable;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Update\Update;
use Yiisoft\Test\Support\Log\SimpleLogger;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UpdateTest extends TestCase
{
    public function testBase(): void
    {
        $update = new Update(99);

        assertSame(99, $update->updateId);
        assertNull($update->message);
        assertNull($update->editedMessage);
        assertNull($update->channelPost);
        assertNull($update->editedChannelPost);
        assertNull($update->businessConnection);
        assertNull($update->businessMessage);
        assertNull($update->editedBusinessMessage);
        assertNull($update->deletedBusinessMessages);
        assertNull($update->messageReaction);
        assertNull($update->messageReactionCount);
        assertNull($update->inlineQuery);
        assertNull($update->chosenInlineResult);
        assertNull($update->callbackQuery);
        assertNull($update->shippingQuery);
        assertNull($update->preCheckoutQuery);
        assertNull($update->poll);
        assertNull($update->pollAnswer);
        assertNull($update->myChatMember);
        assertNull($update->chatMember);
        assertNull($update->chatJoinRequest);
        assertNull($update->chatBoost);
        assertNull($update->removedChatBoost);
        assertNull($update->purchasedPaidMedia);
        assertNull($update->getRaw());
        assertNull($update->getRaw(true));
    }

    public function testFromTelegramResult(): void
    {
        $data = [
            'update_id' => 99,
            'message' => [
                'message_id' => 1,
                'date' => 1623150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Test message',
            ],
            'edited_message' => [
                'message_id' => 2,
                'date' => 1723150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited message',
            ],
            'channel_post' => [
                'message_id' => 3,
                'date' => 1823150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Channel post',
            ],
            'edited_channel_post' => [
                'message_id' => 4,
                'date' => 1923150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited channel post',
            ],
            'business_connection' => [
                'id' => 'bcid1',
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'user_chat_id' => 73,
                'date' => 124455000,
                'rights' => [
                    'can_reply' => true,
                ],
                'is_enabled' => false,
            ],
            'business_message' => [
                'message_id' => 5,
                'date' => 2023150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Business message',
            ],
            'edited_business_message' => [
                'message_id' => 6,
                'date' => 2123150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited business message',
            ],
            'deleted_business_messages' => [
                'business_connection_id' => 'bcid2',
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_ids' => [7, 8],
            ],
            'message_reaction' => [
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_id' => 79,
                'date' => 555677431,
                'old_reaction' => [],
                'new_reaction' => [],
            ],
            'message_reaction_count' => [
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_id' => 80,
                'date' => 555677431,
                'reactions' => [],
            ],
            'inline_query' => [
                'id' => 'iqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'query' => 'inline query',
                'offset' => 'offset',
            ],
            'chosen_inline_result' => [
                'result_id' => 'ri1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'query' => 'inline query',
            ],
            'callback_query' => [
                'id' => 'cbid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'chat_instance' => 'chat12',
            ],
            'shipping_query' => [
                'id' => 'sqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'invoice_payload' => 'payload',
                'shipping_address' => [
                    'country_code' => 'RU',
                    'state' => 'Moscow',
                    'city' => 'Moscow',
                    'street_line1' => 'Street',
                    'street_line2' => 'House',
                    'post_code' => '123456',
                ],
            ],
            'pre_checkout_query' => [
                'id' => 'pcqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'currency' => 'USD',
                'total_amount' => 100,
                'invoice_payload' => 'payload',
                'shipping_option_id' => 'soi1',
            ],
            'purchased_paid_media' => [
                'from' => [
                    'id' => 1235,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
                'paid_media_payload' => 'test',
            ],
            'poll' => [
                'id' => 'poll1',
                'question' => 'Question',
                'options' => [
                    ['text' => 'Option 1', 'voter_count' => 7],
                    ['text' => 'Option 2', 'voter_count' => 5],
                ],
                'total_voter_count' => 12,
                'is_closed' => true,
                'is_anonymous' => false,
                'type' => 'regular',
                'allows_multiple_answers' => false,
            ],
            'poll_answer' => [
                'poll_id' => 'poll2',
                'option_ids' => [0],
            ],
            'my_chat_member' => [
                'chat' => [
                    'id' => 23712,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'date' => 555677431,
                'old_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
                'new_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 24,
                        'is_bot' => false,
                        'first_name' => 'Mike',
                    ],
                ],
            ],
            'chat_member' => [
                'chat' => [
                    'id' => 2399,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'date' => 555677431,
                'old_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
                'new_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 24,
                        'is_bot' => false,
                        'first_name' => 'Mike',
                    ],
                ],
            ],
            'chat_join_request' => [
                'chat' => [
                    'id' => 71326,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'user_chat_id' => 137,
                'date' => 1685000000,
            ],
            'chat_boost' => [
                'chat' => [
                    'id' => 23682,
                    'type' => 'private',
                ],
                'boost' => [
                    'boost_id' => 'bid12',
                    'add_date' => 1685000001,
                    'expiration_date' => 1735000001,
                    'source' => [
                        'source' => 'premium',
                        'user' => [
                            'id' => 23,
                            'is_bot' => false,
                            'first_name' => 'John',
                        ],
                    ],
                ],
            ],
            'removed_chat_boost' => [
                'chat' => [
                    'id' => 1735,
                    'type' => 'private',
                ],
                'boost_id' => 'bid15',
                'remove_date' => 1735000001,
                'source' => [
                    'source' => 'premium',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
        ];
        $update = (new ObjectFactory())->create($data, null, Update::class);

        assertSame(99, $update->updateId);
        assertSame(1, $update->message?->messageId);
        assertSame(2, $update->editedMessage?->messageId);
        assertSame(3, $update->channelPost?->messageId);
        assertSame(4, $update->editedChannelPost?->messageId);
        assertSame('bcid1', $update->businessConnection?->id);
        assertSame(5, $update->businessMessage?->messageId);
        assertSame(6, $update->editedBusinessMessage?->messageId);
        assertSame('bcid2', $update->deletedBusinessMessages?->businessConnectionId);
        assertSame(79, $update->messageReaction?->messageId);
        assertSame(80, $update->messageReactionCount?->messageId);
        assertSame('iqid1', $update->inlineQuery?->id);
        assertSame('ri1', $update->chosenInlineResult?->resultId);
        assertSame('cbid1', $update->callbackQuery?->id);
        assertSame('sqid1', $update->shippingQuery?->id);
        assertSame('pcqid1', $update->preCheckoutQuery?->id);
        assertSame('poll1', $update->poll?->id);
        assertSame('poll2', $update->pollAnswer?->pollId);
        assertSame(23712, $update->myChatMember?->chat->id);
        assertSame(2399, $update->chatMember?->chat->id);
        assertSame(71326, $update->chatJoinRequest?->chat->id);
        assertSame(23682, $update->chatBoost?->chat->id);
        assertSame(1735, $update->removedChatBoost?->chat->id);
        assertSame(1235, $update->purchasedPaidMedia->from->id);
        assertNull($update->getRaw());
        assertNull($update->getRaw(true));
    }

    public function testFromJsonString(): void
    {
        $update = Update::fromJson('{"update_id":33990940}');
        assertSame(33990940, $update->updateId);
        assertSame('{"update_id":33990940}', $update->getRaw());
        assertSame(['update_id' => 33990940], $update->getRaw(true));

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Failed to decode JSON.');
        Update::fromJson('asdf{');
    }

    public function testFromJsonDecodeError(): void
    {
        $logger = new SimpleLogger();

        $exception = null;
        try {
            Update::fromJson('{test', $logger);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Failed to decode JSON.', $exception->getMessage());
        assertSame(
            [
                [
                    'level' => 'error',
                    'message' => 'Failed to decode JSON for "Update" type.',
                    'context' => [
                        'type' => 4,
                        'payload' => '{test',
                    ],
                ],
            ],
            $logger->getMessages(),
        );
    }

    #[TestWith([true])]
    #[TestWith([false])]
    public function testFromJsonCreateUpdateError(bool $useLogger): void
    {
        $logger = $useLogger ? new SimpleLogger() : null;

        $exception = null;
        try {
            Update::fromJson('25', $logger);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Invalid type of value. Expected type is "array", but got "int".', $exception->getMessage());

        if ($useLogger) {
            assertSame(
                [
                    [
                        'level' => 'error',
                        'message' => 'Failed to parse "Update" data. Invalid type of value. Expected type is "array", but got "int".',
                        'context' => [
                            'type' => 4,
                            'payload' => '25',
                        ],
                    ],
                ],
                $logger->getMessages(),
            );
        }
    }
}
