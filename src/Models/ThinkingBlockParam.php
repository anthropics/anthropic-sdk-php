<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ThinkingBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $signature,
        string $thinking,
        string $type
    ) {
        $this->signature = $signature;
        $this->thinking = $thinking;
        $this->type = $type;
    }
}

ThinkingBlockParam::_loadMetadata();
