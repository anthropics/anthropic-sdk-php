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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id, \DateTimeInterface $expiresAt)
    {
        self::introspect();

        $this->id = $id;
        $this->expiresAt = $expiresAt;
    }
}
