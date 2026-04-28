<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsSessionActor\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Attribution for a write made by an agent during a session, through the mounted filesystem at `/mnt/memory/`.
 *
 * @phpstan-type ManagedAgentsSessionActorShape = array{
 *   sessionID: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsSessionActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionActorShape> */
    use SdkModel;

    /**
     * ID of the session that performed the write (a `sesn_...` value). Look up the session via [Retrieve a session](/en/api/sessions-retrieve) for further provenance.
     */
    #[Required('session_id')]
    public string $sessionID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionActor::with(sessionID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionActor)->withSessionID(...)->withType(...)
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
    public static function with(string $sessionID, Type|string $type): self
    {
        $self = new self;

        $self['sessionID'] = $sessionID;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the session that performed the write (a `sesn_...` value). Look up the session via [Retrieve a session](/en/api/sessions-retrieve) for further provenance.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

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
}
