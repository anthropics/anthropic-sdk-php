<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\ErrorResponse;

/**
 * @phpstan-type message_batch_errored_result = array{
 *   error: ErrorResponse, type: string
 * }
 */
final class MessageBatchErroredResult implements BaseModel
{
    /** @use SdkModel<message_batch_errored_result> */
    use SdkModel;

    #[Api]
    public string $type = 'errored';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(ErrorResponse $error): self
    {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function withError(ErrorResponse $error): self
    {
        $obj = clone $this;
        $obj->error = $error;

        return $obj;
    }
}
