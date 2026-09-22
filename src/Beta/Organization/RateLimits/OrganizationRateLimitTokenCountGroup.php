<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type OrganizationRateLimitTokenCountGroupShape = array{
 *   id: string, type: 'token_count'
 * }
 */
final class OrganizationRateLimitTokenCountGroup implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitTokenCountGroupShape> */
    use SdkModel;

    /**
     * Always `token_count`: the Token Count API.
     *
     * @var 'token_count' $type
     */
    #[Required(type: new ConstantOf('token_count'))]
    public string $type = 'token_count';

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    #[Required]
    public string $id;

    /**
     * `new OrganizationRateLimitTokenCountGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitTokenCountGroup::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitTokenCountGroup)->withID(...)
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
     * Always `token_count`: the Token Count API.
     *
     * @param 'token_count' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
