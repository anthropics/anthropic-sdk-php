<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Work data for session work items.
 *
 * This resource type is used when work represents a session that needs to be executed
 * in a self-hosted environment.
 *
 * @phpstan-type SessionWorkDataShape = array{id: string, type: 'session'}
 */
final class SessionWorkData implements BaseModel
{
    /** @use SdkModel<SessionWorkDataShape> */
    use SdkModel;

    /**
     * Type of work data.
     *
     * @var 'session' $type
     */
    #[Required]
    public string $type = 'session';

    /**
     * Session identifier (e.g., 'session_...').
     */
    #[Required]
    public string $id;

    /**
     * `new SessionWorkData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SessionWorkData::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SessionWorkData)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * Session identifier (e.g., 'session_...').
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Type of work data.
     *
     * @param 'session' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
