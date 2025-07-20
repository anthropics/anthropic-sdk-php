<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_cache_creation_alias = array{
 *   ephemeral1hInputTokens: int, ephemeral5mInputTokens: int
 * }
 */
final class BetaCacheCreation implements BaseModel
{
    use Model;

    #[Api('ephemeral_1h_input_tokens')]
    public int $ephemeral1hInputTokens;

    #[Api('ephemeral_5m_input_tokens')]
    public int $ephemeral5mInputTokens;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        int $ephemeral1hInputTokens = 0,
        int $ephemeral5mInputTokens = 0
    ) {
        self::introspect();

        $this->ephemeral1hInputTokens = $ephemeral1hInputTokens;
        $this->ephemeral5mInputTokens = $ephemeral5mInputTokens;
    }
}
