<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An agent acting during a session, for example through the session's mounted filesystem. It names the session itself, not the user or API key that started the session.
 *
 * @phpstan-type ManagedAgentsSessionActorShape = array{
 *   sessionID: string, type: 'session_actor'
 * }
 */
final class ManagedAgentsSessionActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionActorShape> */
    use SdkModel;

    /** @var 'session_actor' $type */
    #[Required(type: new ConstantOf('session_actor'))]
    public string $type = 'session_actor';

    /**
     * ID of the session (a `sesn_...` value). Look up the session via [Retrieve a session](/en/api/beta/sessions/retrieve) for further provenance.
     */
    #[Required('session_id')]
    public string $sessionID;

    /**
     * `new ManagedAgentsSessionActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionActor::with(sessionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionActor())->withSessionID(...)
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
    public static function with(string $sessionID): self
    {
        $self = new self;

        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * ID of the session (a `sesn_...` value). Look up the session via [Retrieve a session](/en/api/beta/sessions/retrieve) for further provenance.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * @param 'session_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
