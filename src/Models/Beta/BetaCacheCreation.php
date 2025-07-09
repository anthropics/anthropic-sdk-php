<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCacheCreation implements BaseModel
{
    use Model;

    #[Api('ephemeral_1h_input_tokens')]
    public int $ephemeral1hInputTokens;

    #[Api('ephemeral_5m_input_tokens')]
    public int $ephemeral5mInputTokens;

    /**
     * @param int $ephemeral1hInputTokens
     * @param int $ephemeral5mInputTokens
     */
    final public function __construct(
        $ephemeral1hInputTokens,
        $ephemeral5mInputTokens
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCacheCreation::_loadMetadata();
