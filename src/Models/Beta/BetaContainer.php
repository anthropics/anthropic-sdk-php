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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string             $id        `required`
     * @param \DateTimeInterface $expiresAt `required`
     */
    final public function __construct($id, $expiresAt)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaContainer::_loadMetadata();
