<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\WidgetQueryType;
use Phptg\BotApi\Type\WidgetQueryTypeData;
use Phptg\BotApi\Type\WidgetQueryTypeSentTransaction;
use Phptg\BotApi\Type\WidgetQueryTypeSignData;

/**
 * @template-extends InterfaceValue<WidgetQueryType>
 */
final readonly class WidgetQueryTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'data' => WidgetQueryTypeData::class,
            'sent_transaction' => WidgetQueryTypeSentTransaction::class,
            'sign_data' => WidgetQueryTypeSignData::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown widget query type.';
    }
}
