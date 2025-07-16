<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRedactedThinkingBlockParam\Type;

final class BetaRedactedThinkingBlockParam implements BaseModel
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

BetaRedactedThinkingBlockParam::_loadMetadata();
