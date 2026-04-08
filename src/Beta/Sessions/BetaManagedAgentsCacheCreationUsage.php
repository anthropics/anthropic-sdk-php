<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Prompt-cache creation token usage broken down by cache lifetime.
 *
 * @phpstan-type BetaManagedAgentsCacheCreationUsageShape = array{
 *   ephemeral1hInputTokens?: int|null, ephemeral5mInputTokens?: int|null
 * }
 */
final class BetaManagedAgentsCacheCreationUsage implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCacheCreationUsageShape> */
    use SdkModel;

    /**
     * Tokens used to create 1-hour ephemeral cache entries.
     */
    #[Optional('ephemeral_1h_input_tokens')]
    public ?int $ephemeral1hInputTokens;

    /**
     * Tokens used to create 5-minute ephemeral cache entries.
     */
    #[Optional('ephemeral_5m_input_tokens')]
    public ?int $ephemeral5mInputTokens;

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
        ?int $ephemeral1hInputTokens = null,
        ?int $ephemeral5mInputTokens = null
    ): self {
        $self = new self;

        null !== $ephemeral1hInputTokens && $self['ephemeral1hInputTokens'] = $ephemeral1hInputTokens;
        null !== $ephemeral5mInputTokens && $self['ephemeral5mInputTokens'] = $ephemeral5mInputTokens;

        return $self;
    }

    /**
     * Tokens used to create 1-hour ephemeral cache entries.
     */
    public function withEphemeral1hInputTokens(
        int $ephemeral1hInputTokens
    ): self {
        $self = clone $this;
        $self['ephemeral1hInputTokens'] = $ephemeral1hInputTokens;

        return $self;
    }

    /**
     * Tokens used to create 5-minute ephemeral cache entries.
     */
    public function withEphemeral5mInputTokens(
        int $ephemeral5mInputTokens
    ): self {
        $self = clone $this;
        $self['ephemeral5mInputTokens'] = $ephemeral5mInputTokens;

        return $self;
    }
}
