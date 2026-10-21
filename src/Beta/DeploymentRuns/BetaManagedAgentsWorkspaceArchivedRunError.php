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
 * @phpstan-type BetaManagedAgentsWorkspaceArchivedRunErrorShape = array{
 *   message: string, type: 'workspace_archived_error'
 * }
 */
final class BetaManagedAgentsWorkspaceArchivedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWorkspaceArchivedRunErrorShape> */
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
     * `new BetaManagedAgentsWorkspaceArchivedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWorkspaceArchivedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWorkspaceArchivedRunError())->withMessage(...)
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
