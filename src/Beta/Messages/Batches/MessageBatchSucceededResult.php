<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_succeeded_result_alias = array{
 *   message: BetaMessage, type: string
 * }
 */
final class MessageBatchSucceededResult implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'succeeded';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(BetaMessage $message): self
    {
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function withMessage(BetaMessage $message): self
    {
        $obj = clone $this;
        $obj->message = $message;

        return $obj;
    }
}
