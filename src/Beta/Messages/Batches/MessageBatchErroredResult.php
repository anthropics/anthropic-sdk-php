<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchErroredResultShape = array{
 *   error: BetaErrorResponse, type: 'errored'
 * }
 */
final class MessageBatchErroredResult implements BaseModel
{
    /** @use SdkModel<MessageBatchErroredResultShape> */
    use SdkModel;

    /** @var 'errored' $type */
    #[Api]
    public string $type = 'errored';

    #[Api]
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
     */
    public static function with(BetaErrorResponse $error): self
    {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function withError(BetaErrorResponse $error): self
    {
        $obj = clone $this;
        $obj->error = $error;

        return $obj;
    }
}
