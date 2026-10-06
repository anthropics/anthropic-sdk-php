<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create an RBAC Group in the Claude Enterprise tenant. Groups created via the API have source type `"direct"`.
 *
 * The RBAC Groups API is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\RBACGroupsService::create()
 *
 * @phpstan-type RBACGroupCreateParamsShape = array{name: string}
 */
final class RBACGroupCreateParams implements BaseModel
{
    /** @use SdkModel<RBACGroupCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    #[Required]
    public string $name;

    /**
     * `new RBACGroupCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACGroupCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACGroupCreateParams())->withName(...)
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
    public static function with(string $name): self
    {
        $self = new self;

        $self['name'] = $name;

        return $self;
    }

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
