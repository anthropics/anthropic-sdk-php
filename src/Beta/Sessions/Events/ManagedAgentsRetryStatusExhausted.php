<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This turn is dead; queued inputs are flushed and the session returns to idle. Client may send a new prompt.
 *
 * @phpstan-type ManagedAgentsRetryStatusExhaustedShape = array{type: 'exhausted'}
 */
final class ManagedAgentsRetryStatusExhausted implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRetryStatusExhaustedShape> */
    use SdkModel;

    /** @var 'exhausted' $type */
    #[Required(type: new ConstantOf('exhausted'))]
    public string $type = 'exhausted';

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

    /**
     * @param 'exhausted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
