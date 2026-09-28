<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PluginUserActorShape = array{
 *   emailAddress: string|null, type: 'user_actor', userID: string
 * }
 */
final class PluginUserActor implements BaseModel
{
    /** @use SdkModel<PluginUserActorShape> */
    use SdkModel;

    /**
     * A member of the organization.
     *
     * @var 'user_actor' $type
     */
    #[Required(type: new ConstantOf('user_actor'))]
    public string $type = 'user_actor';

    /**
     * The member's email address; may be null, for example when they are no longer a member of the organization.
     */
    #[Required('email_address')]
    public ?string $emailAddress;

    /**
     * The member's User ID.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new PluginUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginUserActor::with(emailAddress: ..., userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginUserActor)->withEmailAddress(...)->withUserID(...)
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
    public static function with(?string $emailAddress, string $userID): self
    {
        $self = new self;

        $self['emailAddress'] = $emailAddress;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * The member's email address; may be null, for example when they are no longer a member of the organization.
     */
    public function withEmailAddress(?string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * A member of the organization.
     *
     * @param 'user_actor' $type
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
