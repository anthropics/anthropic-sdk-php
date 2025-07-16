<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaContainer implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id, \DateTimeInterface $expiresAt)
    {
        $this->id = $id;
        $this->expiresAt = $expiresAt;

        self::_introspect();
    }
}
