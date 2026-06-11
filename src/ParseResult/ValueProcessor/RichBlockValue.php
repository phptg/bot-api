<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\RichBlock;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichBlockDivider;
use Phptg\BotApi\Type\RichBlockAnchor;
use Phptg\BotApi\Type\RichBlockBlockQuotation;
use Phptg\BotApi\Type\RichBlockCollage;
use Phptg\BotApi\Type\RichBlockSlideshow;
use Phptg\BotApi\Type\RichBlockDetails;
use Phptg\BotApi\Type\RichBlockAnimation;
use Phptg\BotApi\Type\RichBlockAudio;
use Phptg\BotApi\Type\RichBlockPhoto;
use Phptg\BotApi\Type\RichBlockVideo;
use Phptg\BotApi\Type\RichBlockThinking;
use Phptg\BotApi\Type\RichBlockVoiceNote;
use Phptg\BotApi\Type\RichBlockMap;
use Phptg\BotApi\Type\RichBlockTable;
use Phptg\BotApi\Type\RichBlockPullQuotation;
use Phptg\BotApi\Type\RichBlockList;
use Phptg\BotApi\Type\RichBlockMathematicalExpression;
use Phptg\BotApi\Type\RichBlockFooter;
use Phptg\BotApi\Type\RichBlockPreformatted;
use Phptg\BotApi\Type\RichBlockSectionHeading;

/**
 * @template-extends InterfaceValue<RichBlock>
 */
final readonly class RichBlockValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'paragraph' => RichBlockParagraph::class,
            'heading' => RichBlockSectionHeading::class,
            'pre' => RichBlockPreformatted::class,
            'footer' => RichBlockFooter::class,
            'divider' => RichBlockDivider::class,
            'mathematical_expression' => RichBlockMathematicalExpression::class,
            'anchor' => RichBlockAnchor::class,
            'list' => RichBlockList::class,
            'blockquote' => RichBlockBlockQuotation::class,
            'pullquote' => RichBlockPullQuotation::class,
            'collage' => RichBlockCollage::class,
            'slideshow' => RichBlockSlideshow::class,
            'table' => RichBlockTable::class,
            'details' => RichBlockDetails::class,
            'map' => RichBlockMap::class,
            'animation' => RichBlockAnimation::class,
            'audio' => RichBlockAudio::class,
            'photo' => RichBlockPhoto::class,
            'video' => RichBlockVideo::class,
            'voice_note' => RichBlockVoiceNote::class,
            'thinking' => RichBlockThinking::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown rich block type.';
    }
}
