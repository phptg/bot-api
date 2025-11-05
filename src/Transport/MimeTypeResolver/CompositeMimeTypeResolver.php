<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Type\InputFile;

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

    public function resolve(InputFile $file): ?string
    {
        foreach ($this->resolvers as $resolver) {
            $result = $resolver->resolve($file);
            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
