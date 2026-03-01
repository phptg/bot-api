<?php

declare(strict_types=1);

namespace Phptg\BotApi\Constant;

/**
 * @see https://core.telegram.org/bots/api#formatting-options
 * @see https://core.telegram.org/bots/api#messageentity
 *
 * @api
 */
final class MessageEntityType
{
    public const MENTION = 'mention';
    public const HASHTAG = 'hashtag';
    public const CASHTAG = 'cashtag';
    public const BOT_COMMAND = 'bot_command';
    public const URL = 'url';
    public const EMAIL = 'email';
    public const PHONE_NUMBER = 'phone_number';
    public const BOLD = 'bold';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const STRIKETHROUGH = 'strikethrough';
    public const SPOILER = 'spoiler';
    public const BLOCKQUOTE = 'blockquote';
    public const EXPANDABLE_BLOCKQUOTE = 'expandable_blockquote';
    public const CODE = 'code';
    public const PRE = 'pre';
    public const TEXT_LINK = 'text_link';
    public const TEXT_MENTION = 'text_mention';
    public const CUSTOM_EMOJI = 'custom_emoji';
    public const DATE_TIME = 'date_time';
}
