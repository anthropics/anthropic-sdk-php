<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's workspace was archived.
 *
 * @phpstan-type BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorShape = array{
 *   type: 'workspace_archived_error'
 * }
 */
final class BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'workspace_archived_error' $type */
    #[Required(type: new ConstantOf('workspace_archived_error'))]
    public string $type = 'workspace_archived_error';

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
     * @param 'workspace_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
