<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult;

use Phptg\BotApi\ParseResult\ValueProcessor\ValueProcessorInterface;

final readonly class ResultFactory
{
    private ObjectFactory $objectFactory;

    public function __construct()
    {
        $this->objectFactory = new ObjectFactory();
    }

    /**
     * @psalm-template T
     * @psalm-param ValueProcessorInterface<T> $type
     * @psalm-return T
     */
    public function create(mixed $result, ValueProcessorInterface $type): mixed
    {
        return $type->process($result, null, $this->objectFactory);
    }
}
