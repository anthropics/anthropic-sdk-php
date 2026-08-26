<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type OrganizationRateLimitValueShape = array{type: string, value: int}
 */
final class OrganizationRateLimitValue implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitValueShape> */
    use SdkModel;

    /**
     * The limiter type (for example, `requests_per_minute` or `input_tokens_per_minute`).
     */
    #[Required]
    public string $type;

    /**
     * The configured limit value for this limiter type.
     */
    #[Required]
    public int $value;

    /**
     * `new OrganizationRateLimitValue()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitValue::with(type: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitValue)->withType(...)->withValue(...)
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
    public static function with(string $type, int $value): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['value'] = $value;

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
     * The configured limit value for this limiter type.
     */
    public function withValue(int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
