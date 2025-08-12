<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_stop_event_alias = array{type: string}
 */
final class RawMessageStopEvent implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'message_stop';

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
    public static function from(): self
    {
        return new self;
    }
}
