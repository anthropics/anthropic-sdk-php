<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PluginTargetOrganizationMemberShape = array{
 *   type: 'organization_member', userID: string
 * }
 */
final class PluginTargetOrganizationMember implements BaseModel
{
    /** @use SdkModel<PluginTargetOrganizationMemberShape> */
    use SdkModel;

    /**
     * One member of the organization.
     *
     * @var 'organization_member' $type
     */
    #[Required(type: new ConstantOf('organization_member'))]
    public string $type = 'organization_member';

    /**
     * The member's User ID.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new PluginTargetOrganizationMember()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginTargetOrganizationMember::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginTargetOrganizationMember())->withUserID(...)
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
    public static function with(string $userID): self
    {
        $self = new self;

        $self['userID'] = $userID;

        return $self;
    }

    /**
     * One member of the organization.
     *
     * @param 'organization_member' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The member's User ID.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
