<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The session encountered a terminal error and will transition to `terminated` state.
 *
 * @phpstan-type ManagedAgentsRetryStatusTerminalShape = array{type: 'terminal'}
 */
final class ManagedAgentsRetryStatusTerminal implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRetryStatusTerminalShape> */
    use SdkModel;

    /** @var 'terminal' $type */
    #[Required(type: new ConstantOf('terminal'))]
    public string $type = 'terminal';

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
     * @param 'terminal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
