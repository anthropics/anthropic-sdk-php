<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CacheCreationShape = array{
 *   ephemeral1hInputTokens: int, ephemeral5mInputTokens: int
 * }
 */
final class CacheCreation implements BaseModel
{
    /** @use SdkModel<CacheCreationShape> */
    use SdkModel;

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    #[Required('ephemeral_1h_input_tokens')]
    public int $ephemeral1hInputTokens;

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    #[Required('ephemeral_5m_input_tokens')]
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
        $this->initialize();
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
        $self = new self;

        $self['ephemeral1hInputTokens'] = $ephemeral1hInputTokens;
        $self['ephemeral5mInputTokens'] = $ephemeral5mInputTokens;

        return $self;
    }

    /**
     * The number of input tokens used to create the 1 hour cache entry.
     */
    public function withEphemeral1hInputTokens(
        int $ephemeral1hInputTokens
    ): self {
        $self = clone $this;
        $self['ephemeral1hInputTokens'] = $ephemeral1hInputTokens;

        return $self;
    }

    /**
     * The number of input tokens used to create the 5 minute cache entry.
     */
    public function withEphemeral5mInputTokens(
        int $ephemeral5mInputTokens
    ): self {
        $self = clone $this;
        $self['ephemeral5mInputTokens'] = $ephemeral5mInputTokens;

        return $self;
    }
}
