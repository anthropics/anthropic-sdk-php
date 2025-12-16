<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaMessageShape from \Anthropic\Beta\Messages\BetaMessage
 *
 * @phpstan-type MessageBatchSucceededResultShape = array{
 *   message: BetaMessage|BetaMessageShape, type: 'succeeded'
 * }
 */
final class MessageBatchSucceededResult implements BaseModel
{
    /** @use SdkModel<MessageBatchSucceededResultShape> */
    use SdkModel;

    /** @var 'succeeded' $type */
    #[Required]
    public string $type = 'succeeded';

    #[Required]
    public BetaMessage $message;

    /**
     * `new MessageBatchSucceededResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatchSucceededResult::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatchSucceededResult)->withMessage(...)
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
     * @param BetaMessageShape $message
     */
    public static function with(BetaMessage|array $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * @param BetaMessageShape $message
     */
    public function withMessage(BetaMessage|array $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
