<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class Metadata implements BaseModel
{
    use Model;

    #[Api('user_id', optional: true)]
    public ?string $userID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?string $userID = null)
    {
        self::_introspect();
        $this->unsetOptionalProperties();

        null != $userID && $this->userID = $userID;
    }
}
