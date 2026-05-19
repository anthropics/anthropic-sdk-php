<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `glob` tool. Returns paths matching a
 * doublestar glob pattern, newest first.
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401GlobInputShape = array{
 *   pattern: string, path?: string|null
 * }
 */
final class BetaManagedAgentsAgentToolset20260401GlobInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401GlobInputShape> */
    use SdkModel;

    /**
     * Doublestar glob pattern (e.g. `**\/*.go`). Absolute patterns
     * are only permitted when the runner is configured to allow
     * them.
     */
    #[Required]
    public string $pattern;

    /**
     * Optional directory root to search under. Defaults to the
     * runner's working directory.
     */
    #[Optional]
    public ?string $path;

    /**
     * `new BetaManagedAgentsAgentToolset20260401GlobInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401GlobInput::with(pattern: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401GlobInput)->withPattern(...)
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
    public static function with(string $pattern, ?string $path = null): self
    {
        $self = new self;

        $self['pattern'] = $pattern;

        null !== $path && $self['path'] = $path;

        return $self;
    }

    /**
     * Doublestar glob pattern (e.g. `**\/*.go`). Absolute patterns
     * are only permitted when the runner is configured to allow
     * them.
     */
    public function withPattern(string $pattern): self
    {
        $self = clone $this;
        $self['pattern'] = $pattern;

        return $self;
    }

    /**
     * Optional directory root to search under. Defaults to the
     * runner's working directory.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }
}
