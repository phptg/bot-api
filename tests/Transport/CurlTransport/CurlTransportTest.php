<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\CurlTransport;

use CurlShareHandle;
use CURLStringFile;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Phptg\BotApi\Tests\Curl\CurlMock;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CurlTransportTest extends TestCase
{
    public function testGet(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->get('//url/getMe?key=value&array=%5B1%2C%22test%22%5D');

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertCount(4, $options);
        assertTrue($options[CURLOPT_HTTPGET]);
        assertSame('//url/getMe?key=value&array=%5B1%2C%22test%22%5D', $options[CURLOPT_URL]);
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testPost(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->post(
            '//url/logOut',
            '',
            [
                'Content-Length' => '0',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        );

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertCount(6, $options);
        assertTrue($options[CURLOPT_POST]);
        assertSame('//url/logOut', $options[CURLOPT_URL]);
        assertSame('', $options[CURLOPT_POSTFIELDS]);
        assertSame(
            [
                'Content-Length: 0',
                'Content-Type: application/json; charset=utf-8',
            ],
            $options[CURLOPT_HTTPHEADER],
        );
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testWithoutCode(): void
    {
        $transport = new CurlTransport(
            curl: new CurlMock(
                execResult: '{"ok":true,"result":[]}',
            ),
        );

        $response = $transport->get('getMe');

        assertSame(0, $response->statusCode);
    }

    public function testPostWithLocalFiles(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->postWithFiles(
            '//url/sendPhoto',
            [],
            [
                'photo1' => InputFile::fromLocalFile(__DIR__ . '/photo.png'),
                'photo2' => InputFile::fromLocalFile(__DIR__ . '/photo.png', 'photo.png'),
            ],
        );

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertCount(5, $options);
        assertTrue($options[CURLOPT_POST]);
        assertSame('//url/sendPhoto', $options[CURLOPT_URL]);
        assertEquals(
            [
                'photo1' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    '',
                ),
                'photo2' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    'photo.png',
                ),
            ],
            $options[CURLOPT_POSTFIELDS],
        );
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testSeekableResource(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        $resource = fopen(__DIR__ . '/photo.png', 'r');
        stream_get_contents($resource);
        $transport->postWithFiles(
            'sendPhoto',
            [],
            [
                'photo' => new InputFile($resource),
            ],
        );

        assertEquals(
            [
                'photo' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    '',
                ),
            ],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testCloseOnException(): void
    {
        $curl = new CurlMock(new RuntimeException());
        $transport = new CurlTransport(curl: $curl);

        try {
            $transport->get('getMe');
        } catch (Throwable) {
        }

        assertSame(1, $curl->getCountCallOfClose());
    }

    public function testShareOptions(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );

        (new CurlTransport(curl: $curl))->get('getMe');

        assertSame(
            [
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_COOKIE],
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_DNS],
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_SSL_SESSION],
            ],
            $curl->getShareOptions(),
        );
    }
}
