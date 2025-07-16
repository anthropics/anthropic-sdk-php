<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ThinkingBlock\Type;

final class ThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'thinking';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $signature,
        string $thinking,
        string $type = 'thinking'
    ) {
        $this->signature = $signature;
        $this->thinking = $thinking;
        $this->type = $type;
    }
}

ThinkingBlock::_loadMetadata();
