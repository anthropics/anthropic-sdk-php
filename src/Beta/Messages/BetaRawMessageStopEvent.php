<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawMessageStopEventShape = array{type: 'message_stop'}
 */
final class BetaRawMessageStopEvent implements BaseModel
{
    /** @use SdkModel<BetaRawMessageStopEventShape> */
    use SdkModel;

    /** @var 'message_stop' $type */
    #[Required]
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
