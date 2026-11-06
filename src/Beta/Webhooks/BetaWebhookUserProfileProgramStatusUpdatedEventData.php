<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaWebhookUserProfileProgramStatusUpdatedEventDataShape = array{
 *   id: string,
 *   organizationID: string,
 *   type: 'user_profile.program_status_updated',
 * }
 */
final class BetaWebhookUserProfileProgramStatusUpdatedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookUserProfileProgramStatusUpdatedEventDataShape> */
    use SdkModel;

    /** @var 'user_profile.program_status_updated' $type */
    #[Required(type: new ConstantOf('user_profile.program_status_updated'))]
    public string $type = 'user_profile.program_status_updated';

    /**
     * ID of the user profile that triggered the event.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    /**
     * `new BetaWebhookUserProfileProgramStatusUpdatedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookUserProfileProgramStatusUpdatedEventData::with(
     *   id: ..., organizationID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookUserProfileProgramStatusUpdatedEventData())
     *   ->withID(...)
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
    public static function with(string $id, string $organizationID): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * ID of the user profile that triggered the event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * @param 'user_profile.program_status_updated' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
