<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Scope of the monthly spend cap Anthropic sets for a Claude Console
 * organization from its usage tier, or a higher cap Anthropic granted the
 * organization. Read-only; its `created_at` and `updated_at` are the
 * organization's creation time, so `amount` can change while `updated_at` stays
 * the same.
 *
 * @phpstan-type SpendLimitUsageTierScopeShape = array{type: 'usage_tier'}
 */
final class SpendLimitUsageTierScope implements BaseModel
{
    /** @use SdkModel<SpendLimitUsageTierScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `usage_tier` for this scope.
     *
     * @var 'usage_tier' $type
     */
    #[Required(type: new ConstantOf('usage_tier'))]
    public string $type = 'usage_tier';

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
     * Scope type. Always `usage_tier` for this scope.
     *
     * @param 'usage_tier' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
