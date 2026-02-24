<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

use Phptg\BotApi\Transport\TransportInterface;
use Phptg\BotApi\Transport\ApiResponse;

final class TransportMock implements TransportInterface
{
    private ?string $url = null;

    private ?string $sentBody = null;
    private ?array $sentHeaders = null;

    private ?array $sentData = null;
    private ?array $sentFiles = null;

    /**
     * @param resource|null $downloadFileResource
     */
    public function __construct(
        private readonly ApiResponse $response = new ApiResponse(200, '{"ok":true,"result":true}'),
        private readonly mixed $downloadFileResource = null,
    ) {}

    public static function successResult(mixed $result): self
    {
        return new self(
            new ApiResponse(
                200,
                json_encode(['ok' => true, 'result' => $result], JSON_THROW_ON_ERROR),
            ),
        );
    }

    public function get(string $url): ApiResponse
    {
        $this->url = $url;
        return $this->response;
    }

    public function post(string $url, string $body, array $headers): ApiResponse
    {
        $this->url = $url;
        $this->sentBody = $body;
        $this->sentHeaders = $headers;
        return $this->response;
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        $this->url = $url;
        $this->sentData = $data;
        $this->sentFiles = $files;
        return $this->response;
    }

    public function downloadFile(string $url): mixed
    {
        if ($this->downloadFileResource !== null) {
            return $this->downloadFileResource;
        }

        /** @var resource $stream */
        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, $url);
        rewind($stream);
        return $stream;
    }

    public function url(): ?string
    {
        return $this->url;
    }

    public function sentHeaders(): ?array
    {
        return $this->sentHeaders;
    }

    public function sentBody(): ?string
    {
        return $this->sentBody;
    }

    public function sentData(): ?array
    {
        return $this->sentData;
    }

    public function sentFiles(): ?array
    {
        return $this->sentFiles;
    }
}
