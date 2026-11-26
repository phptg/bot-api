<?php

declare(strict_types=1);

namespace Phptg\BotApi;

/**
 * API method that the Telegram server may hold for a number of seconds before responding, that is, a long polling
 * method such as `getUpdates`.
 *
 * @template-covariant TResult
 * @template-extends MethodInterface<TResult>
 *
 * @api
 */
interface LongPollingMethodInterface extends MethodInterface
{
    /**
     * The maximum number of seconds the server may hold the request before responding.
     * `0` disables long polling and the request is sent as a regular GET request.
     *
     * @return non-negative-int
     */
    public function getLongPollingTimeout(): int;
}
