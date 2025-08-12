<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    #[Api('ephemeral_1h_input_tokens')]
    public int $ephemeral1hInputTokens;

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    #[Api('ephemeral_5m_input_tokens')]
    public int $ephemeral5mInputTokens;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function from(
        int $ephemeral1hInputTokens = 0,
        int $ephemeral5mInputTokens = 0
    ): self {
        $obj = new self;

        $obj->ephemeral1hInputTokens = $ephemeral1hInputTokens;
        $obj->ephemeral5mInputTokens = $ephemeral5mInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    public function setEphemeral1hInputTokens(int $ephemeral1hInputTokens): self
    {
        $this->ephemeral1hInputTokens = $ephemeral1hInputTokens;

        return $this;
    }

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    public function setEphemeral5mInputTokens(int $ephemeral5mInputTokens): self
    {
        $this->ephemeral5mInputTokens = $ephemeral5mInputTokens;

        return $this;
    }
}
