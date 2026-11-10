<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\WidgetQuery;
use Phptg\BotApi\Type\WidgetQueryTypeData;
use Phptg\BotApi\Type\WidgetQueryTypeSignData;
use Phptg\BotApi\Type\WidgetQueryWallet;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class WidgetQueryTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'First');
        $type = new WidgetQueryTypeData();
        $query = new WidgetQuery('query1', $user, 'cid1', $type, 'data1');

        assertSame('query1', $query->id);
        assertSame($user, $query->from);
        assertSame('cid1', $query->chatInstance);
        assertSame($type, $query->type);
        assertSame('data1', $query->data);
        assertNull($query->chat);
        assertNull($query->messageId);
        assertNull($query->inlineMessageId);
        assertNull($query->chatType);
        assertNull($query->widgetId);
    }

    public function testFull(): void
    {
        $user = new User(1, false, 'First');
        $chat = new Chat(23, 'private');
        $type = new WidgetQueryTypeSignData(
            new WidgetQueryWallet('EQCDwallet', '100500'),
            '{"serial_id":123}',
        );
        $query = new WidgetQuery('query1', $user, 'cid1', $type, 'data1', $chat, 99, 'm12', 'sender', 'w1');

        assertSame('query1', $query->id);
        assertSame($user, $query->from);
        assertSame('cid1', $query->chatInstance);
        assertSame($type, $query->type);
        assertSame('data1', $query->data);
        assertSame($chat, $query->chat);
        assertSame(99, $query->messageId);
        assertSame('m12', $query->inlineMessageId);
        assertSame('sender', $query->chatType);
        assertSame('w1', $query->widgetId);
    }

    public function testFromTelegramResult(): void
    {
        $query = (new ObjectFactory())->create([
            'id' => 'query1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'First',
            ],
            'chat_instance' => 'cid1',
            'type' => [
                'type' => 'data',
            ],
            'data' => 'data1',
        ], null, WidgetQuery::class);

        assertSame('query1', $query->id);
        assertSame(1, $query->from->id);
        assertSame('cid1', $query->chatInstance);
        $type = $query->type;
        assertInstanceOf(WidgetQueryTypeData::class, $type);
        assertSame('data', $type->getType());
        assertNull($type->walletCard);
        assertSame('data1', $query->data);
        assertNull($query->chat);
        assertNull($query->messageId);
        assertNull($query->inlineMessageId);
        assertNull($query->chatType);
        assertNull($query->widgetId);
    }

    public function testFromTelegramResultFull(): void
    {
        $query = (new ObjectFactory())->create([
            'id' => 'query1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'First',
            ],
            'chat' => [
                'id' => 23,
                'type' => 'private',
            ],
            'message_id' => 99,
            'inline_message_id' => 'm12',
            'chat_instance' => 'cid1',
            'chat_type' => 'sender',
            'type' => [
                'type' => 'sign_data',
                'wallet' => [
                    'address' => 'EQCDwallet',
                    'amount' => '100500',
                    'public_key' => 'a1b2c3d4',
                    'state_init' => 'te6cckEBAQEAJg',
                ],
                'sign_data' => '{"serial_id":123}',
            ],
            'data' => 'data1',
            'widget_id' => 'w1',
        ], null, WidgetQuery::class);

        assertSame('query1', $query->id);
        assertSame(1, $query->from->id);
        assertInstanceOf(Chat::class, $query->chat);
        assertSame(23, $query->chat->id);
        assertSame(99, $query->messageId);
        assertSame('m12', $query->inlineMessageId);
        assertSame('cid1', $query->chatInstance);
        assertSame('sender', $query->chatType);
        $type = $query->type;
        assertInstanceOf(WidgetQueryTypeSignData::class, $type);
        assertSame('sign_data', $type->getType());
        assertSame('EQCDwallet', $type->wallet->address);
        assertSame('a1b2c3d4', $type->wallet->publicKey);
        assertSame('{"serial_id":123}', $type->signData);
        assertSame('data1', $query->data);
        assertSame('w1', $query->widgetId);
    }
}
