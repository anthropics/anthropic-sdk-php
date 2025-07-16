<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RedactedThinkingBlockParam\Type;

final class RedactedThinkingBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $data, string $type)
    {
        $this->data = $data;
        $this->type = $type;
    }
}

RedactedThinkingBlockParam::_loadMetadata();
