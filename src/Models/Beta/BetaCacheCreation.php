<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCacheCreation implements BaseModel
{
    use Model;

    #[Api('ephemeral_1h_input_tokens')]
    public int $ephemeral1hInputTokens = 0;

    #[Api('ephemeral_5m_input_tokens')]
    public int $ephemeral5mInputTokens = 0;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        int $ephemeral1hInputTokens = 0,
        int $ephemeral5mInputTokens = 0
    ) {
        $this->ephemeral1hInputTokens = $ephemeral1hInputTokens;
        $this->ephemeral5mInputTokens = $ephemeral5mInputTokens;
    }
}

BetaCacheCreation::__introspect();
