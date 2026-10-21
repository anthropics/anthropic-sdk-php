<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A human user, for example acting through the Anthropic Console.
 *
 * @phpstan-type ManagedAgentsUserActorShape = array{
 *   type: 'user_actor', userID: string
 * }
 */
final class ManagedAgentsUserActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserActorShape> */
    use SdkModel;

    /** @var 'user_actor' $type */
    #[Required(type: new ConstantOf('user_actor'))]
    public string $type = 'user_actor';

    /**
     * ID of the user (a `user_...` value).
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new ManagedAgentsUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserActor::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserActor())->withUserID(...)
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
     * @param 'user_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the user (a `user_...` value).
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
