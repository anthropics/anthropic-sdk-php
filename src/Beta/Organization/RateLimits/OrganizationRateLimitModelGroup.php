<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type OrganizationRateLimitModelGroupShape = array{
 *   id: string, displayName: string, type: 'model_group'
 * }
 */
final class OrganizationRateLimitModelGroup implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitModelGroupShape> */
    use SdkModel;

    /**
     * Always `model_group`: a family of models.
     *
     * @var 'model_group' $type
     */
    #[Required]
    public string $type = 'model_group';

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    #[Required]
    public string $id;

    /**
     * Human-readable name of the model group (for example, `Claude Sonnet 4.x`). For display only; it may change.
     */
    #[Required('display_name')]
    public string $displayName;

    /**
     * `new OrganizationRateLimitModelGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitModelGroup::with(id: ..., displayName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitModelGroup)->withID(...)->withDisplayName(...)
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
    public static function with(string $id, string $displayName): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Human-readable name of the model group (for example, `Claude Sonnet 4.x`). For display only; it may change.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Always `model_group`: a family of models.
     *
     * @param 'model_group' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
