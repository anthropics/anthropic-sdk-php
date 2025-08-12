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
    public static function new(BetaMessage $message): self
    {
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function setMessage(BetaMessage $message): self
    {
        $this->message = $message;

        return $this;
    }
}
