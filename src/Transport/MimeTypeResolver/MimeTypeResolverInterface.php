<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Type\InputFile;

/**
 * @api
 */
interface MimeTypeResolverInterface
{
    /**
     * Resolves the MIME type for the given file.
     *
     * @param InputFile $inputFile The file to resolve MIME type for.
     *
     * @return string|null The resolved MIME type, or `null` if it cannot be determined.
     */
    public function resolve(InputFile $inputFile): ?string;
}
