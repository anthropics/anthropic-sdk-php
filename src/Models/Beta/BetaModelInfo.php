<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaModelInfo implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    #[Api('display_name')]
    public string $displayName;

    #[Api]
    public string $type;

    /**
     * @param string             $id
     * @param \DateTimeInterface $createdAt
     * @param string             $displayName
     * @param string             $type
     */
    final public function __construct($id, $createdAt, $displayName, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaModelInfo::_loadMetadata();
