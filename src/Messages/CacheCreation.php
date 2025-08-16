<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type cache_creation_alias = array{
 *   ephemeral1hInputTokens: int, ephemeral5mInputTokens: int
 * }
 */
final class CacheCreation implements BaseModel
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

    /**
     * `new CacheCreation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CacheCreation::with(ephemeral1hInputTokens: ..., ephemeral5mInputTokens: ...)
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
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
    public function withEphemeral1hInputTokens(
        int $ephemeral1hInputTokens
    ): self {
        $obj = clone $this;
        $obj->ephemeral1hInputTokens = $ephemeral1hInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    public function withEphemeral5mInputTokens(
        int $ephemeral5mInputTokens
    ): self {
        $obj = clone $this;
        $obj->ephemeral5mInputTokens = $ephemeral5mInputTokens;

        return $obj;
    }
}
