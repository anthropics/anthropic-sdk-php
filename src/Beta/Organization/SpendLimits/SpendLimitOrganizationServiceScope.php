<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type SpendLimitOrganizationServiceScopeShape = array{
 *   service: string, type: 'organization_service'
 * }
 */
final class SpendLimitOrganizationServiceScope implements BaseModel
{
    /** @use SdkModel<SpendLimitOrganizationServiceScopeShape> */
    use SdkModel;

    /** @var 'organization_service' $type */
    #[Required(type: new ConstantOf('organization_service'))]
    public string $type = 'organization_service';

    #[Required]
    public string $service;

    /**
     * `new SpendLimitOrganizationServiceScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitOrganizationServiceScope::with(service: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitOrganizationServiceScope)->withService(...)
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
    public static function with(string $service): self
    {
        $self = new self;

        $self['service'] = $service;

        return $self;
    }

    public function withService(string $service): self
    {
        $self = clone $this;
        $self['service'] = $service;

        return $self;
    }

    /**
     * @param 'organization_service' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
