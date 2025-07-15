<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ModelInfo implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    #[Api('display_name')]
    public string $displayName;

    #[Api]
    public string $type = 'model';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        string $displayName,
        string $type = 'model',
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->displayName = $displayName;
        $this->type = $type;
    }
}

ModelInfo::_loadMetadata();
