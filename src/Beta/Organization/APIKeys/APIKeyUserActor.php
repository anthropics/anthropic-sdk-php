<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyUserActorShape = array{type: 'user_actor', userID: string}
 */
final class APIKeyUserActor implements BaseModel
{
    /** @use SdkModel<APIKeyUserActorShape> */
    use SdkModel;

    /**
     * Principal type. Always `"user_actor"` for a User.
     *
     * @var 'user_actor' $type
     */
    #[Required]
    public string $type = 'user_actor';

    /**
     * ID of the User the API key acts as.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new APIKeyUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyUserActor::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyUserActor)->withUserID(...)
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
     * Principal type. Always `"user_actor"` for a User.
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
     * ID of the User the API key acts as.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
