<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class RedactedThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
    public string $data;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $data)
    {
        $this->data = $data;
    }
}

RedactedThinkingBlock::__introspect();
