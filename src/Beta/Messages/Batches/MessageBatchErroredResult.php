<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaAPIError;
use Anthropic\Beta\BetaAuthenticationError;
use Anthropic\Beta\BetaBillingError;
use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Beta\BetaGatewayTimeoutError;
use Anthropic\Beta\BetaInvalidRequestError;
use Anthropic\Beta\BetaNotFoundError;
use Anthropic\Beta\BetaOverloadedError;
use Anthropic\Beta\BetaPermissionError;
use Anthropic\Beta\BetaRateLimitError;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchErroredResultShape = array{
 *   error: BetaErrorResponse, type?: 'errored'
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
    public BetaErrorResponse $error;

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
     * @param BetaErrorResponse|array{
     *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError,
     *   requestID: string|null,
     *   type?: 'error',
     * } $error
     */
    public static function with(BetaErrorResponse|array $error): self
    {
        $obj = new self;

        $obj['error'] = $error;

        return $obj;
    }

    /**
     * @param BetaErrorResponse|array{
     *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError,
     *   requestID: string|null,
     *   type?: 'error',
     * } $error
     */
    public function withError(BetaErrorResponse|array $error): self
    {
        $obj = clone $this;
        $obj['error'] = $error;

        return $obj;
    }
}
