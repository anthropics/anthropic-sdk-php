<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WorkspaceRateLimitUpdateValueShape = array{
 *   type: WorkspaceRateLimitType|value-of<WorkspaceRateLimitType>, value: int|null
 * }
 */
final class WorkspaceRateLimitUpdateValue implements BaseModel
{
    /** @use SdkModel<WorkspaceRateLimitUpdateValueShape> */
    use SdkModel;

    /**
     * Rate limiter type.
     *
     * @var value-of<WorkspaceRateLimitType> $type
     */
    #[Required(enum: WorkspaceRateLimitType::class)]
    public string $type;

    /**
     * New limit value. Set to null to clear the workspace override and fall back to the organization limit.
     */
    #[Required]
    public ?int $value;

    /**
     * `new WorkspaceRateLimitUpdateValue()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRateLimitUpdateValue::with(type: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRateLimitUpdateValue())->withType(...)->withValue(...)
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
     * @param WorkspaceRateLimitType|value-of<WorkspaceRateLimitType> $type
     */
    public static function with(
        WorkspaceRateLimitType|string $type,
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
     * @param WorkspaceRateLimitType|value-of<WorkspaceRateLimitType> $type
     */
    public function withType(WorkspaceRateLimitType|string $type): self
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
