<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWorkspaceRateLimitValueShape = array{
 *   orgLimit: int|null, type: string, value: int
 * }
 */
final class BetaWorkspaceRateLimitValue implements BaseModel
{
    /** @use SdkModel<BetaWorkspaceRateLimitValueShape> */
    use SdkModel;

    /**
     * The organization-level value for the same limiter type, for reference. `null` when the organization has no limit configured for this limiter type.
     */
    #[Required('org_limit')]
    public ?int $orgLimit;

    /**
     * The limiter type (for example, `requests_per_minute` or `input_tokens_per_minute`).
     */
    #[Required]
    public string $type;

    /**
     * The workspace-level override value for this limiter type.
     */
    #[Required]
    public int $value;

    /**
     * `new BetaWorkspaceRateLimitValue()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWorkspaceRateLimitValue::with(orgLimit: ..., type: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWorkspaceRateLimitValue)
     *   ->withOrgLimit(...)
     *   ->withType(...)
     *   ->withValue(...)
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
    public static function with(?int $orgLimit, string $type, int $value): self
    {
        $self = new self;

        $self['orgLimit'] = $orgLimit;
        $self['type'] = $type;
        $self['value'] = $value;

        return $self;
    }

    /**
     * The organization-level value for the same limiter type, for reference. `null` when the organization has no limit configured for this limiter type.
     */
    public function withOrgLimit(?int $orgLimit): self
    {
        $self = clone $this;
        $self['orgLimit'] = $orgLimit;

        return $self;
    }

    /**
     * The limiter type (for example, `requests_per_minute` or `input_tokens_per_minute`).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The workspace-level override value for this limiter type.
     */
    public function withValue(int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
