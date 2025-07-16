<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ThinkingConfigDisabled\Type;

final class ThinkingConfigDisabled implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $type)
    {
        $this->type = $type;
    }
}

ThinkingConfigDisabled::_loadMetadata();
