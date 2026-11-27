<?php

declare(strict_types=1);

namespace Phptg\BotApi;

/**
 * API method that the Telegram server may hold for a number of seconds before responding, that is, a long polling
 * method such as `getUpdates`.
 *
 * The long polling timeout is taken into account only when the method is sent as a GET request; for other HTTP
 * methods it is ignored and the request is sent as a regular one.
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
