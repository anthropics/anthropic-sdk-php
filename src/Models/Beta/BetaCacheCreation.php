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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int $ephemeral1hInputTokens `required`
     * @param int $ephemeral5mInputTokens `required`
     */
    final public function __construct(
        $ephemeral1hInputTokens = 0,
        $ephemeral5mInputTokens = 0
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCacheCreation::_loadMetadata();
