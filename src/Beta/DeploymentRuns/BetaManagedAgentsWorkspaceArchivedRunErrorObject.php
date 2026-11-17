<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's workspace was archived.
 *
 * @phpstan-type BetaManagedAgentsWorkspaceArchivedRunErrorObjectShape = array{
 *   message: string, type: 'workspace_archived_error'
 * }
 */
class BetaManagedAgentsWorkspaceArchivedRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWorkspaceArchivedRunErrorObjectShape> */
    use SdkModel;

    /** @var 'workspace_archived_error' $type */
    #[Required(type: new ConstantOf('workspace_archived_error'))]
    public string $type = 'workspace_archived_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsWorkspaceArchivedRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWorkspaceArchivedRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWorkspaceArchivedRunErrorObject())->withMessage(...)
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
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
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

class_alias(
    BetaManagedAgentsWorkspaceArchivedRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsWorkspaceArchivedRunError',
);
