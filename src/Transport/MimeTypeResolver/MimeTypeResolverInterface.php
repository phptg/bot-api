<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Transport\InputFileData;

/**
 * @api
 */
interface MimeTypeResolverInterface
{
    /**
     * Resolves the MIME type for the given input file data.
     *
     * @param InputFileData $fileData The input file data to resolve MIME type for.
     *
     * @return string|null The resolved MIME type, or `null` if it cannot be determined.
     */
    public function resolve(InputFileData $fileData): ?string;
}
