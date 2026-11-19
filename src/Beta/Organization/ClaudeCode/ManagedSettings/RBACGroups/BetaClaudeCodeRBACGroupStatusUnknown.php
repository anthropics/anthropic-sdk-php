<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaClaudeCodeRBACGroupStatusUnknownShape = array{type: 'unknown'}
 */
final class BetaClaudeCodeRBACGroupStatusUnknown implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeRBACGroupStatusUnknownShape> */
    use SdkModel;

    /**
     * Always `unknown`.
     *
     * @var 'unknown' $type
     */
    #[Required(type: new ConstantOf('unknown'))]
    public string $type = 'unknown';

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
     * Always `unknown`.
     *
     * @param 'unknown' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
