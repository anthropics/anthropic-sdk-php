<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type OrganizationRateLimitSkillsGroupShape = array{
 *   id: string, type: 'skills'
 * }
 */
final class OrganizationRateLimitSkillsGroup implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitSkillsGroupShape> */
    use SdkModel;

    /**
     * Always `skills`: the Skills API.
     *
     * @var 'skills' $type
     */
    #[Required(type: new ConstantOf('skills'))]
    public string $type = 'skills';

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    #[Required]
    public string $id;

    /**
     * `new OrganizationRateLimitSkillsGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitSkillsGroup::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitSkillsGroup)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

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
     * Always `skills`: the Skills API.
     *
     * @param 'skills' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
