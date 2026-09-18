<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type OrganizationRateLimitFilesGroupShape = array{
 *   id: string, type: 'files'
 * }
 */
final class OrganizationRateLimitFilesGroup implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitFilesGroupShape> */
    use SdkModel;

    /**
     * Always `files`: the Files API.
     *
     * @var 'files' $type
     */
    #[Required]
    public string $type = 'files';

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    #[Required]
    public string $id;

    /**
     * `new OrganizationRateLimitFilesGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitFilesGroup::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitFilesGroup)->withID(...)
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
     * Always `files`: the Files API.
     *
     * @param 'files' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
