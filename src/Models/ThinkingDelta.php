<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ThinkingDelta\Type;

final class ThinkingDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $thinking;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'thinking_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $thinking,
        string $type = 'thinking_delta'
    ) {
        $this->thinking = $thinking;
        $this->type = $type;
    }
}

ThinkingDelta::_loadMetadata();
