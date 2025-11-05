<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

use Phptg\BotApi\Transport\TransportInterface;
use Phptg\BotApi\Transport\ApiResponse;

final class TransportMock implements TransportInterface
{
    private ?string $url = null;

    /**
     * @psalm-var list<list{string, string}>
     */
    private array $savedFiles = [];

    public function __construct(
        private readonly ?ApiResponse $response = null,
    ) {}

    public function get(string $url): ApiResponse
    {
        $this->url = $url;
        return $this->response ?? new ApiResponse(200, '{"ok":true,"result":true}');
    }

    public function post(string $url, string $body, array $headers): ApiResponse
    {
        $this->url = $url;
        return $this->response ?? new ApiResponse(200, '{"ok":true,"result":true}');
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        $this->url = $url;
        return $this->response ?? new ApiResponse(200, '{"ok":true,"result":true}');
    }

    public function downloadFile(string $url): string
    {
        return $url;
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        $this->savedFiles[] = [$url, $savePath];
    }

    /**
     * @psalm-return list<list{string, string}>
     */
    public function savedFiles(): array
    {
        return $this->savedFiles;
    }

    public function url(): ?string
    {
        return $this->url;
    }
}
