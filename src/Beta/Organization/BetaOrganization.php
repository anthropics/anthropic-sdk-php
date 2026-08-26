<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaOrganizationShape = array{
 *   id: string, name: string, type: 'organization'
 * }
 */
final class BetaOrganization implements BaseModel
{
    /** @use SdkModel<BetaOrganizationShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Organizations, this is always `"organization"`.
     *
     * @var 'organization' $type
     */
    #[Required]
    public string $type = 'organization';

    /**
     * ID of the Organization.
     */
    #[Required]
    public string $id;

    /**
     * Name of the Organization.
     */
    #[Required]
    public string $name;

    /**
     * `new BetaOrganization()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOrganization::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOrganization)->withID(...)->withName(...)
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
    public static function with(string $id, string $name): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        return $self;
    }

    /**
     * ID of the Organization.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Name of the Organization.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Object type.
     *
     * For Organizations, this is always `"organization"`.
     *
     * @param 'organization' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
