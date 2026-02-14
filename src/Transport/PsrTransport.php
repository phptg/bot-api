<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use LogicException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

use function is_resource;

/**
 * @api
 */
final readonly class PsrTransport implements TransportInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function get(string $url): ApiResponse
    {
        return $this->send(
            $this->requestFactory->createRequest('GET', $url),
        );
    }

    public function post(string $url, string $body, array $headers): ApiResponse
    {
        $request = $this->requestFactory->createRequest('POST', $url);

        $stream = $this->streamFactory->createStream($body);
        $request = $request->withBody($stream);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->send($request);
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        $streamBuilder = new MultipartStreamBuilder($this->streamFactory);
        foreach ($data as $key => $value) {
            $streamBuilder->addResource($key, (string) $value);
        }
        foreach ($files as $key => $file) {
            if (!is_resource($file->resource) && !$file->resource instanceof StreamInterface) {
                throw new LogicException('File resource must be a valid resource or instance of StreamInterface.');
            }
            $streamBuilder->addResource(
                $key,
                $file->resource,
                $file->filename === null ? [] : ['filename' => $file->filename],
            );
        }
        $body = $streamBuilder->build();
        $contentType = 'multipart/form-data; boundary=' . $streamBuilder->getBoundary() . '; charset=utf-8';

        $request = $this->requestFactory
            ->createRequest('POST', $url)
            ->withHeader('Content-Length', (string) $body->getSize())
            ->withHeader('Content-Type', $contentType)
            ->withBody($body);

        return $this->send($request);
    }

    public function downloadFile(string $url, mixed $stream): void
    {
        $request = $this->requestFactory->createRequest('GET', $url);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        $body = $response->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        $resource = $body->detach();

        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new DownloadFileException($errorString);
            },
        );
        try {
            if ($resource === null) {
                $result = fwrite($stream, (string) $body);
                if ($result === false) {
                    throw new DownloadFileException('Failed to write file content to stream.');
                }
                return;
            }
            try {
                stream_copy_to_stream($resource, $stream);
            } finally {
                fclose($resource);
            }
        } finally {
            restore_error_handler();
        }
    }

    private function send(RequestInterface $request): ApiResponse
    {
        $response = $this->client->sendRequest($request);

        $body = $response->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        return new ApiResponse(
            $response->getStatusCode(),
            $body->getContents(),
        );
    }
}
