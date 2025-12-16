<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\ErrorResponse;

/**
 * @phpstan-import-type ErrorResponseShape from \Anthropic\ErrorResponse
 *
 * @phpstan-type MessageBatchErroredResultShape = array{
 *   error: ErrorResponse|ErrorResponseShape, type: 'errored'
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
     * @param ErrorResponseShape $error
     */
    public static function with(ErrorResponse|array $error): self
    {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * @param ErrorResponseShape $error
     */
    public function withError(ErrorResponse|array $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
