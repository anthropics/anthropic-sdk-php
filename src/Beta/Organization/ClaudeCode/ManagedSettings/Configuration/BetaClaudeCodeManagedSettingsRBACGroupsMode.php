<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaClaudeCodeManagedSettingsRBACGroupsModeShape = array{
 *   type: 'rbac_groups'
 * }
 */
final class BetaClaudeCodeManagedSettingsRBACGroupsMode implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeManagedSettingsRBACGroupsModeShape> */
    use SdkModel;

    /**
     * Always `rbac_groups`.
     *
     * @var 'rbac_groups' $type
     */
    #[Required(type: new ConstantOf('rbac_groups'))]
    public string $type = 'rbac_groups';

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
     * Always `rbac_groups`.
     *
     * @param 'rbac_groups' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
