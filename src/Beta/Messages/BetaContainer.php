<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Information about the container used in the request (for the code execution tool).
 */
final class BetaContainer implements BaseModel
{
    use SdkModel;

    /**
     * Identifier for the container used in this request.
     */
    #[Api]
    public string $id;

    /**
     * The time at which the container will expire.
     */
    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * `new BetaContainer()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainer::with(id: ..., expiresAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContainer)->withID(...)->withExpiresAt(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $id, \DateTimeInterface $expiresAt): self
    {
        $obj = new self;

        $obj->id = $id;
        $obj->expiresAt = $expiresAt;

        return $obj;
    }

    /**
     * Identifier for the container used in this request.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * The time at which the container will expire.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $obj = clone $this;
        $obj->expiresAt = $expiresAt;

        return $obj;
    }
}
