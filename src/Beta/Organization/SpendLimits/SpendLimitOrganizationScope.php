<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type SpendLimitOrganizationScopeShape = array{type: 'organization'}
 */
final class SpendLimitOrganizationScope implements BaseModel
{
    /** @use SdkModel<SpendLimitOrganizationScopeShape> */
    use SdkModel;

    /** @var 'organization' $type */
    #[Required(type: new ConstantOf('organization'))]
    public string $type = 'organization';

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
     * @param 'organization' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
