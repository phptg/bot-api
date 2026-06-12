<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Attribute;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\RichText;
use Phptg\BotApi\Type\RichTextBold;
use Phptg\BotApi\Type\RichTextItalic;
use Phptg\BotApi\Type\RichTextDateTime;
use Phptg\BotApi\Type\RichTextCode;
use Phptg\BotApi\Type\RichTextCustomEmoji;
use Phptg\BotApi\Type\RichTextMathematicalExpression;
use Phptg\BotApi\Type\RichTextAnchor;
use Phptg\BotApi\Type\RichTextAnchorLink;
use Phptg\BotApi\Type\RichTextReference;
use Phptg\BotApi\Type\RichTextReferenceLink;
use Phptg\BotApi\Type\RichTextBotCommand;
use Phptg\BotApi\Type\RichTextCashtag;
use Phptg\BotApi\Type\RichTextHashtag;
use Phptg\BotApi\Type\RichTextMention;
use Phptg\BotApi\Type\RichTextBankCardNumber;
use Phptg\BotApi\Type\RichTextEmailAddress;
use Phptg\BotApi\Type\RichTextPhoneNumber;
use Phptg\BotApi\Type\RichTextUrl;
use Phptg\BotApi\Type\RichTextMarked;
use Phptg\BotApi\Type\RichTextSubscript;
use Phptg\BotApi\Type\RichTextSuperscript;
use Phptg\BotApi\Type\RichTextTextMention;
use Phptg\BotApi\Type\RichTextSpoiler;
use Phptg\BotApi\Type\RichTextStrikethrough;
use Phptg\BotApi\Type\RichTextUnderline;

use function array_map;
use function is_array;
use function is_string;

/**
 * @template-implements ValueProcessorInterface<string|array|RichText>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class RichTextValue implements ValueProcessorInterface
{
    /**
     * @var array<string, class-string<RichText>>
     */
    private const CLASS_MAP = [
        'bold' => RichTextBold::class,
        'italic' => RichTextItalic::class,
        'underline' => RichTextUnderline::class,
        'strikethrough' => RichTextStrikethrough::class,
        'spoiler' => RichTextSpoiler::class,
        'date_time' => RichTextDateTime::class,
        'text_mention' => RichTextTextMention::class,
        'subscript' => RichTextSubscript::class,
        'superscript' => RichTextSuperscript::class,
        'marked' => RichTextMarked::class,
        'code' => RichTextCode::class,
        'custom_emoji' => RichTextCustomEmoji::class,
        'mathematical_expression' => RichTextMathematicalExpression::class,
        'url' => RichTextUrl::class,
        'email_address' => RichTextEmailAddress::class,
        'phone_number' => RichTextPhoneNumber::class,
        'bank_card_number' => RichTextBankCardNumber::class,
        'mention' => RichTextMention::class,
        'hashtag' => RichTextHashtag::class,
        'cashtag' => RichTextCashtag::class,
        'bot_command' => RichTextBotCommand::class,
        'anchor' => RichTextAnchor::class,
        'anchor_link' => RichTextAnchorLink::class,
        'reference' => RichTextReference::class,
        'reference_link' => RichTextReferenceLink::class,
    ];

    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): string|array|RichText
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_array($value)) {
            if (array_is_list($value)) {
                return array_map(
                    fn(mixed $item): string|array|RichText => $this->process($item, $key, $objectFactory),
                    $value,
                );
            }
            return $this->createObject($value, $key, $objectFactory);
        }

        throw new InvalidTypeOfValueInResultException($key, $value, 'string or array');
    }

    private function createObject(array $value, ?string $key, ObjectFactory $objectFactory): RichText
    {
        if (!isset($value['type'])) {
            throw new NotFoundKeyInResultException('type');
        }
        if (!is_string($value['type'])) {
            throw new InvalidTypeOfValueInResultException('type', $value['type'], 'string');
        }
        $className = self::CLASS_MAP[$value['type']]
            ?? throw new TelegramParseResultException('Unknown rich text type.');
        return $objectFactory->create($value, $key, $className);
    }
}
