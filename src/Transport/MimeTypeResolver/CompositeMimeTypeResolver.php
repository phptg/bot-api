<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Transport\InputFileData;

/**
 * @api
 */
final readonly class CompositeMimeTypeResolver implements MimeTypeResolverInterface
{
    /**
     * @psalm-var list<MimeTypeResolverInterface>
     */
    private array $resolvers;

    /**
     * @no-named-arguments
     */
    public function __construct(MimeTypeResolverInterface ...$resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function resolve(InputFileData $fileData): ?string
    {
        foreach ($this->resolvers as $resolver) {
            $result = $resolver->resolve($fileData);
            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
