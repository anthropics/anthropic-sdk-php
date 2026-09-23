<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue\Source;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue\Source
 *
 * @phpstan-type BetaWorkspaceRateLimitValueShape = array{
 *   orgLimit: int|null, source: SourceShape, type: string, value: int
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
     * Where `value` comes from. `organization` values are listed only when `include_inherited` is `true`, and then `value` equals `org_limit`.
     *
     * @var SourceVariants $source
     */
    #[Required(union: Source::class)]
    public BetaWorkspaceRateLimitWorkspaceSource|BetaWorkspaceRateLimitOrganizationSource $source;

    /**
     * The limiter type (for example, `requests_per_minute` or `input_tokens_per_minute`).
     */
    #[Required]
    public string $type;

    /**
     * The workspace's value for this limiter type: the workspace-level override when `source.type` is `workspace`, otherwise the organization's value.
     */
    #[Required]
    public int $value;

    /**
     * `new BetaWorkspaceRateLimitValue()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWorkspaceRateLimitValue::with(
     *   orgLimit: ..., source: ..., type: ..., value: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWorkspaceRateLimitValue)
     *   ->withOrgLimit(...)
     *   ->withSource(...)
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
     *
     * @param SourceShape $source
     */
    public static function with(
        ?int $orgLimit,
        BetaWorkspaceRateLimitWorkspaceSource|array|BetaWorkspaceRateLimitOrganizationSource $source,
        string $type,
        int $value,
    ): self {
        $self = new self;

        $self['orgLimit'] = $orgLimit;
        $self['source'] = $source;
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
     * Where `value` comes from. `organization` values are listed only when `include_inherited` is `true`, and then `value` equals `org_limit`.
     *
     * @param SourceShape $source
     */
    public function withSource(
        BetaWorkspaceRateLimitWorkspaceSource|array|BetaWorkspaceRateLimitOrganizationSource $source,
    ): self {
        $self = clone $this;
        $self['source'] = $source;

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
     * The workspace's value for this limiter type: the workspace-level override when `source.type` is `workspace`, otherwise the organization's value.
     */
    public function withValue(int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
