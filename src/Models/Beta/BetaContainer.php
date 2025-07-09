<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaContainer implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * @param string             $id
     * @param \DateTimeInterface $expiresAt
     */
    final public function __construct($id, $expiresAt)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaContainer::_loadMetadata();
