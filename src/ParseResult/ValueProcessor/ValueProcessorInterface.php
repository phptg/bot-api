<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\ObjectFactory;

/**
 * @template-covariant T
 */
interface ValueProcessorInterface
{
    /**
     * @return T
     */
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed;
}
