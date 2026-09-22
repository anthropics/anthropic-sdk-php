<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type OrganizationRateLimitWebSearchGroupShape = array{
 *   id: string, type: 'web_search'
 * }
 */
final class OrganizationRateLimitWebSearchGroup implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitWebSearchGroupShape> */
    use SdkModel;

    /**
     * Always `web_search`: the Messages API web search tool.
     *
     * @var 'web_search' $type
     */
    #[Required(type: new ConstantOf('web_search'))]
    public string $type = 'web_search';

    /**
     * Opaque identifier of the rate-limit group (for example, `rlg_01VPTCmyiu5ZLsWkcxYG2pY8`). It is the same in every organization and never changes, unlike the entry's own identifier, which differs per organization.
     */
    #[Required]
    public string $id;

    /**
     * `new OrganizationRateLimitWebSearchGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimitWebSearchGroup::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimitWebSearchGroup)->withID(...)
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
     * Always `web_search`: the Messages API web search tool.
     *
     * @param 'web_search' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
