<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set or clear rate-limit overrides for one rate-limit group in a workspace.
 *
 * Only the limiter types named in `limits` change: an integer `value` sets
 * that type's override and `null` clears it. Types not named keep their
 * current value. A value above the organization's own limit is stored, but
 * the organization limit still applies, so the lower of the two is
 * enforced.
 *
 * Returns the targeted group's entry with this request applied, in the shape
 * `GET /v1/organizations/workspaces/{workspace_id}/rate_limits` returns.
 * Changes take effect within about an hour.
 *
 * @see Anthropic\Services\Organization\Workspaces\RateLimitsService::update()
 *
 * @phpstan-import-type WorkspaceRateLimitUpdateValueShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitUpdateValue
 *
 * @phpstan-type RateLimitUpdateParamsShape = array{
 *   workspaceID: string,
 *   limits: list<WorkspaceRateLimitUpdateValue|WorkspaceRateLimitUpdateValueShape>,
 * }
 */
final class RateLimitUpdateParams implements BaseModel
{
    /** @use SdkModel<RateLimitUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The ID of the workspace.
     */
    #[Required]
    public string $workspaceID;

    /**
     * Limits to set or clear. Unspecified limit types are unchanged.
     *
     * @var list<WorkspaceRateLimitUpdateValue> $limits
     */
    #[Required(list: WorkspaceRateLimitUpdateValue::class)]
    public array $limits;

    /**
     * `new RateLimitUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RateLimitUpdateParams::with(workspaceID: ..., limits: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RateLimitUpdateParams())->withWorkspaceID(...)->withLimits(...)
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
     * @param list<WorkspaceRateLimitUpdateValue|WorkspaceRateLimitUpdateValueShape> $limits
     */
    public static function with(string $workspaceID, array $limits): self
    {
        $self = new self;

        $self['workspaceID'] = $workspaceID;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * The ID of the workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Limits to set or clear. Unspecified limit types are unchanged.
     *
     * @param list<WorkspaceRateLimitUpdateValue|WorkspaceRateLimitUpdateValueShape> $limits
     */
    public function withLimits(array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }
}
