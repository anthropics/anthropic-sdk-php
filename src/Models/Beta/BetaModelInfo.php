<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaModelInfo implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'model';

    #[Api]
    public string $id;

    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    #[Api('display_name')]
    public string $displayName;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        string $displayName
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->displayName = $displayName;
    }
}

BetaModelInfo::__introspect();
