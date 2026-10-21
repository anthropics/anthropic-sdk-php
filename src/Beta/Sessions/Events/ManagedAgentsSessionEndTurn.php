<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent completed its turn naturally and is ready for the next user message.
 *
 * @phpstan-type ManagedAgentsSessionEndTurnShape = array{type: 'end_turn'}
 */
final class ManagedAgentsSessionEndTurn implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionEndTurnShape> */
    use SdkModel;

    /** @var 'end_turn' $type */
    #[Required(type: new ConstantOf('end_turn'))]
    public string $type = 'end_turn';

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
     * @param 'end_turn' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
