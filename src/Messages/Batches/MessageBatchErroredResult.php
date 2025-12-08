<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\APIErrorObject;
use Anthropic\AuthenticationError;
use Anthropic\BillingError;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\ErrorResponse;
use Anthropic\GatewayTimeoutError;
use Anthropic\InvalidRequestError;
use Anthropic\NotFoundError;
use Anthropic\OverloadedError;
use Anthropic\PermissionError;
use Anthropic\RateLimitError;

/**
 * @phpstan-type MessageBatchErroredResultShape = array{
 *   error: ErrorResponse, type: 'errored'
 * }
 */
final class MessageBatchErroredResult implements BaseModel
{
    /** @use SdkModel<MessageBatchErroredResultShape> */
    use SdkModel;

    /** @var 'errored' $type */
    #[Required]
    public string $type = 'errored';

    #[Required]
    public ErrorResponse $error;

    /**
     * `new MessageBatchErroredResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatchErroredResult::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatchErroredResult)->withError(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ErrorResponse|array{
     *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
     *   request_id: string|null,
     *   type: 'error',
     * } $error
     */
    public static function with(ErrorResponse|array $error): self
    {
        $obj = new self;

        $obj['error'] = $error;

        return $obj;
    }

    /**
     * @param ErrorResponse|array{
     *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
     *   request_id: string|null,
     *   type: 'error',
     * } $error
     */
    public function withError(ErrorResponse|array $error): self
    {
        $obj = clone $this;
        $obj['error'] = $error;

        return $obj;
    }
}
