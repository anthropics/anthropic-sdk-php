<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaWorkspaceRateLimitWorkspaceSourceShape = array{
 *   type: 'workspace'
 * }
 */
final class BetaWorkspaceRateLimitWorkspaceSource implements BaseModel
{
    /** @use SdkModel<BetaWorkspaceRateLimitWorkspaceSourceShape> */
    use SdkModel;

    /**
     * Always `workspace`: a workspace-level override is stored.
     *
     * @var 'workspace' $type
     */
    #[Required(type: new ConstantOf('workspace'))]
    public string $type = 'workspace';

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
     * Always `workspace`: a workspace-level override is stored.
     *
     * @param 'workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
