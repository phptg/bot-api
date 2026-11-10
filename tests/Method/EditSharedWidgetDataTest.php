<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\EditSharedWidgetData;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditSharedWidgetDataTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditSharedWidgetData('widgetId', 'publicData');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editSharedWidgetData', $method->getApiMethod());
        assertSame(
            [
                'widget_id' => 'widgetId',
                'public_data' => 'publicData',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new EditSharedWidgetData('widgetId', 'publicData', 60);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editSharedWidgetData', $method->getApiMethod());
        assertSame(
            [
                'widget_id' => 'widgetId',
                'public_data' => 'publicData',
                'cache_time' => 60,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditSharedWidgetData('widgetId', 'publicData');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
