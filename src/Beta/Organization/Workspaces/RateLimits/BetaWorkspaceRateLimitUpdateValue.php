<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWorkspaceRateLimitUpdateValueShape = array{
 *   type: BetaWorkspaceRateLimitType|value-of<BetaWorkspaceRateLimitType>,
 *   value: int|null,
 * }
 */
final class BetaWorkspaceRateLimitUpdateValue implements BaseModel
{
    /** @use SdkModel<BetaWorkspaceRateLimitUpdateValueShape> */
    use SdkModel;

    /**
     * Rate limiter type.
     *
     * @var value-of<BetaWorkspaceRateLimitType> $type
     */
    #[Required(enum: BetaWorkspaceRateLimitType::class)]
    public string $type;

    /**
     * New limit value. Set to null to clear the workspace override and fall back to the organization limit.
     */
    #[Required]
    public ?int $value;

    /**
     * `new BetaWorkspaceRateLimitUpdateValue()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWorkspaceRateLimitUpdateValue::with(type: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWorkspaceRateLimitUpdateValue())->withType(...)->withValue(...)
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
     * @param BetaWorkspaceRateLimitType|value-of<BetaWorkspaceRateLimitType> $type
     */
    public static function with(
        BetaWorkspaceRateLimitType|string $type,
        ?int $value
    ): self {
        $self = new self;

        $self['type'] = $type;
        $self['value'] = $value;

        return $self;
    }

    /**
     * Rate limiter type.
     *
     * @param BetaWorkspaceRateLimitType|value-of<BetaWorkspaceRateLimitType> $type
     */
    public function withType(BetaWorkspaceRateLimitType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * New limit value. Set to null to clear the workspace override and fall back to the organization limit.
     */
    public function withValue(?int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
