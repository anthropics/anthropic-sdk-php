<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMetadata implements BaseModel
{
    use Model;

    #[Api('user_id', optional: true)]
    public ?string $userID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?string $userID = null)
    {
        $this->userID = $userID;
    }
}

BetaMetadata::__introspect();
