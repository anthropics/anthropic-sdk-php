<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Information about the container used in the request (for the code execution tool).
 *
 * @phpstan-type ContainerShape = array{id: string, expiresAt: \DateTimeInterface}
 */
final class Container implements BaseModel
{
    /** @use SdkModel<ContainerShape> */
    use SdkModel;

    /**
     * Identifier for the container used in this request.
     */
    #[Required]
    public string $id;

    /**
     * The time at which the container will expire.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * `new Container()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Container::with(id: ..., expiresAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Container)->withID(...)->withExpiresAt(...)
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
    public static function with(string $id, \DateTimeInterface $expiresAt): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Identifier for the container used in this request.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The time at which the container will expire.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }
}
