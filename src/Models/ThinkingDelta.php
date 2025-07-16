<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ThinkingDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'thinking_delta';

    #[Api]
    public string $thinking;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $thinking)
    {
        $this->thinking = $thinking;
    }
}

ThinkingDelta::_loadMetadata();
