<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CacheCreationShape = array{
 *   ephemeral_1h_input_tokens: int, ephemeral_5m_input_tokens: int
 * }
 */
final class CacheCreation implements BaseModel
{
    /** @use SdkModel<CacheCreationShape> */
    use SdkModel;

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    #[Api]
    public int $ephemeral_1h_input_tokens;

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    #[Api]
    public int $ephemeral_5m_input_tokens;

    /**
     * `new CacheCreation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CacheCreation::with(
     *   ephemeral_1h_input_tokens: ..., ephemeral_5m_input_tokens: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CacheCreation)
     *   ->withEphemeral1hInputTokens(...)
     *   ->withEphemeral5mInputTokens(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        int $ephemeral_1h_input_tokens = 0,
        int $ephemeral_5m_input_tokens = 0
    ): self {
        $obj = new self;

        $obj['ephemeral_1h_input_tokens'] = $ephemeral_1h_input_tokens;
        $obj['ephemeral_5m_input_tokens'] = $ephemeral_5m_input_tokens;

        return $obj;
    }

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    public function withEphemeral1hInputTokens(
        int $ephemeral1hInputTokens
    ): self {
        $obj = clone $this;
        $obj['ephemeral_1h_input_tokens'] = $ephemeral1hInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    public function withEphemeral5mInputTokens(
        int $ephemeral5mInputTokens
    ): self {
        $obj = clone $this;
        $obj['ephemeral_5m_input_tokens'] = $ephemeral5mInputTokens;

        return $obj;
    }
}
