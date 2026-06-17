<?php

namespace Anthropic\Core\Exceptions;

/**
 * An error that opts the current request attempt back into the SDK's retry
 * policy: throw it from a middleware to have the attempt retried, the same way
 * a connection failure or a retryable status code is retried.
 *
 * The attempt is only retried while `maxRetries` has not been exhausted, and
 * each retry waits the usual backoff delay. Once retries are exhausted this
 * exception surfaces to the caller as-is (the original cause, if any, is kept
 * as `getPrevious()`) rather than being wrapped in another exception.
 */
class RetryableException extends AnthropicException
{
    /** @var string */
    protected const DESC = 'Anthropic Retryable Error';

    public function __construct(
        string $message = 'Retryable error.',
        ?\Throwable $previous = null,
    ) {
        parent::__construct(message: $message, previous: $previous);
    }
}
