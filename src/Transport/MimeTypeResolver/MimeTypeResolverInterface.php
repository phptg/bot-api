<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Type\InputFile;

/**
 * @api
 */
interface MimeTypeResolverInterface
{
    public function resolve(InputFile $file): ?string;
}
