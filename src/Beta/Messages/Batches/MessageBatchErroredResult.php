<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaErrorResponseShape from \Anthropic\Beta\BetaErrorResponse
 *
 * @phpstan-type MessageBatchErroredResultShape = array{
 *   error: BetaErrorResponse|BetaErrorResponseShape, type: 'errored'
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
     * @param BetaErrorResponseShape $error
     */
    public static function with(BetaErrorResponse|array $error): self
    {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * @param BetaErrorResponseShape $error
     */
    public function withError(BetaErrorResponse|array $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
