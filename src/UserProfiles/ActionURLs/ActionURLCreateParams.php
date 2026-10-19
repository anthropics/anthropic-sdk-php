<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles\ActionURLs;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Action URL.
 *
 * @see Anthropic\Services\UserProfiles\ActionURLsService::create()
 *
 * @phpstan-import-type UserProfileEnrollEndUserActionShape from \Anthropic\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction
 *
 * @phpstan-type ActionURLCreateParamsShape = array{
 *   action: UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape,
 *   workspaceID?: string|null,
 * }
 */
final class ActionURLCreateParams implements BaseModel
{
    /** @use SdkModel<ActionURLCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The action that the person who opens the URL takes.
     */
    #[Required]
    public UserProfileEnrollEndUserAction $action;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    /**
     * `new ActionURLCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ActionURLCreateParams::with(action: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ActionURLCreateParams())->withAction(...)
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
     *
     * @param UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape $action
     */
    public static function with(
        UserProfileEnrollEndUserAction|array $action,
        ?string $workspaceID = null
    ): self {
        $self = new self;

        $self['action'] = $action;

        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The action that the person who opens the URL takes.
     *
     * @param UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape $action
     */
    public function withAction(
        UserProfileEnrollEndUserAction|array $action
    ): self {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
