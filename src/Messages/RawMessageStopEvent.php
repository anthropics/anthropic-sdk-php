<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_stop_event = array{type: string}
 */
final class RawMessageStopEvent implements BaseModel
{
    /** @use SdkModel<raw_message_stop_event> */
    use SdkModel;

    #[Api]
    public string $type = 'message_stop';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }
}
