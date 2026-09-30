<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Scope selecting one workspace of a Claude Console organization.
 *
 * @phpstan-type SpendLimitWorkspaceScopeShape = array{
 *   type: 'workspace', workspaceID: string
 * }
 */
final class SpendLimitWorkspaceScope implements BaseModel
{
    /** @use SdkModel<SpendLimitWorkspaceScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `workspace` for this scope.
     *
     * @var 'workspace' $type
     */
    #[Required(type: new ConstantOf('workspace'))]
    public string $type = 'workspace';

    /**
     * Tagged ID of the workspace the spend limit applies to.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new SpendLimitWorkspaceScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitWorkspaceScope::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitWorkspaceScope)->withWorkspaceID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $workspaceID): self
    {
        $self = new self;

        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Scope type. Always `workspace` for this scope.
     *
     * @param 'workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged ID of the workspace the spend limit applies to.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
