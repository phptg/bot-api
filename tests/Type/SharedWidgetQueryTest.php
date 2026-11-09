<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SharedWidgetQuery;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\WidgetQueryTypeData;
use Phptg\BotApi\Type\WidgetQueryTypeSentTransaction;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class SharedWidgetQueryTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'First');
        $type = new WidgetQueryTypeData();
        $query = new SharedWidgetQuery('query1', $user, $type, 'data1', 'w1');

        assertSame('query1', $query->id);
        assertSame($user, $query->from);
        assertSame($type, $query->type);
        assertSame('data1', $query->data);
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
            'type' => [
                'type' => 'sent_transaction',
                'wallet' => [
                    'address' => 'EQCDwallet',
                    'amount' => '100500',
                ],
                'msg_hash' => 'abcdef123456',
            ],
            'data' => 'data1',
            'widget_id' => 'w1',
        ], null, SharedWidgetQuery::class);

        assertSame('query1', $query->id);
        assertSame(1, $query->from->id);
        $type = $query->type;
        assertInstanceOf(WidgetQueryTypeSentTransaction::class, $type);
        assertSame('sent_transaction', $type->getType());
        assertSame('EQCDwallet', $type->wallet->address);
        assertSame('abcdef123456', $type->msgHash);
        assertSame('data1', $query->data);
        assertSame('w1', $query->widgetId);
    }
}
