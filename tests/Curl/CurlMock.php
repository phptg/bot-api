<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Curl;

use CurlHandle;
use CurlShareHandle;
use Throwable;
use Phptg\BotApi\Curl\CurlInterface;

use function curl_init;
use function is_array;
use function is_resource;

final class CurlMock implements CurlInterface
{
    /**
     * @var array<int, mixed>|null
     */
    private ?array $options = null;

    /**
     * @var list<array{int, mixed}>
     */
    private array $shareOptions = [];

    /**
     * @param array<int, mixed> $getinfoResult
     */
    public function __construct(
        private readonly string|Throwable $execResult = '',
        private readonly array $getinfoResult = [],
        private readonly ?Throwable $initException = null,
    ) {}

    public function exec(CurlHandle $handle): string
    {
        if ($this->execResult instanceof Throwable) {
            throw $this->execResult;
        }

        if (is_array($this->options) && is_resource($this->options[CURLOPT_FILE] ?? null)) {
            fwrite($this->options[CURLOPT_FILE], $this->execResult);
        }

        return $this->execResult;
    }

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed
    {
        return $option === null ? $this->getinfoResult : ($this->getinfoResult[$option] ?? null);
    }

    public function init(): CurlHandle
    {
        if ($this->initException !== null) {
            throw $this->initException;
        }
        return curl_init();
    }

    public function setopt_array(CurlHandle $handle, array $options): void
    {
        $this->options = $options;
    }

    public function share_setopt(CurlShareHandle $handle, int $option, mixed $value): void
    {
        $this->shareOptions[] = [$option, $value];
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @return list<array{int, mixed}>
     */
    public function getShareOptions(): array
    {
        return $this->shareOptions;
    }
}
