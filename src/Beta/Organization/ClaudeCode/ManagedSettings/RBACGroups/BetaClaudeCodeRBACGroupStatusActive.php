<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaClaudeCodeRBACGroupStatusActiveShape = array{type: 'active'}
 */
final class BetaClaudeCodeRBACGroupStatusActive implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeRBACGroupStatusActiveShape> */
    use SdkModel;

    /**
     * Always `active`.
     *
     * @var 'active' $type
     */
    #[Required(type: new ConstantOf('active'))]
    public string $type = 'active';

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
     * Always `active`.
     *
     * @param 'active' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
