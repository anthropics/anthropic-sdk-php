<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_raw_message_start_event_alias = array{
 *   message: BetaMessage, type: string
 * }
 */
final class BetaRawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_start';

    #[Api]
    public BetaMessage $message;

    /**
     * `new BetaRawMessageStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawMessageStartEvent::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawMessageStartEvent)->withMessage(...)
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
