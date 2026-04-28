<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsUserActor\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Attribution for a write made by a human user through the Anthropic Console.
 *
 * @phpstan-type ManagedAgentsUserActorShape = array{
 *   type: Type|value-of<Type>, userID: string
 * }
 */
final class ManagedAgentsUserActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserActorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * ID of the user who performed the write (a `user_...` value).
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new ManagedAgentsUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserActor::with(type: ..., userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserActor)->withType(...)->withUserID(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(Type|string $type, string $userID): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the user who performed the write (a `user_...` value).
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
