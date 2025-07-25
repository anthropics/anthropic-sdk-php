<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Information about the container used in the request (for the code execution tool).
 *
 * @phpstan-type beta_container_alias = array{
 *   id: string, expiresAt: \DateTimeInterface
 * }
 */
final class BetaContainer implements BaseModel
{
    use Model;

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
    public static function new(string $id, \DateTimeInterface $expiresAt): self
    {
        $obj = new self;

        $obj->id = $id;
        $obj->expiresAt = $expiresAt;

        return $obj;
    }

    /**
     * Identifier for the container used in this request.
     */
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * The time at which the container will expire.
     */
    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
