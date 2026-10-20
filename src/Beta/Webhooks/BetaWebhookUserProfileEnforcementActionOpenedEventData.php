<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaWebhookUserProfileEnforcementActionOpenedEventDataShape = array{
 *   id: string,
 *   enforcementActionID: string,
 *   organizationID: string,
 *   type: 'user_profile.enforcement_action_opened',
 * }
 */
final class BetaWebhookUserProfileEnforcementActionOpenedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookUserProfileEnforcementActionOpenedEventDataShape> */
    use SdkModel;

    /** @var 'user_profile.enforcement_action_opened' $type */
    #[Required(type: new ConstantOf('user_profile.enforcement_action_opened'))]
    public string $type = 'user_profile.enforcement_action_opened';

    /**
     * ID of the user profile the enforcement action is on.
     */
    #[Required]
    public string $id;

    /**
     * ID (`enac_...`) of the enforcement action that was opened or resolved.
     */
    #[Required('enforcement_action_id')]
    public string $enforcementActionID;

    #[Required('organization_id')]
    public string $organizationID;

    /**
     * `new BetaWebhookUserProfileEnforcementActionOpenedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookUserProfileEnforcementActionOpenedEventData::with(
     *   id: ..., enforcementActionID: ..., organizationID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookUserProfileEnforcementActionOpenedEventData())
     *   ->withID(...)
     *   ->withEnforcementActionID(...)
     *   ->withOrganizationID(...)
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
    public static function with(
        string $id,
        string $enforcementActionID,
        string $organizationID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['enforcementActionID'] = $enforcementActionID;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * ID of the user profile the enforcement action is on.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * ID (`enac_...`) of the enforcement action that was opened or resolved.
     */
    public function withEnforcementActionID(string $enforcementActionID): self
    {
        $self = clone $this;
        $self['enforcementActionID'] = $enforcementActionID;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * @param 'user_profile.enforcement_action_opened' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
