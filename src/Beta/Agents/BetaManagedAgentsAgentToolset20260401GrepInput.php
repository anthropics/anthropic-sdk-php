<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `grep` tool. Searches file contents for
 * a regular expression, returning matching lines.
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401GrepInputShape = array{
 *   pattern: string, path?: string|null
 * }
 */
final class BetaManagedAgentsAgentToolset20260401GrepInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401GrepInputShape> */
    use SdkModel;

    /**
     * Regular expression to search for.
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
     * `new BetaManagedAgentsAgentToolset20260401GrepInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401GrepInput::with(pattern: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401GrepInput)->withPattern(...)
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
     * Regular expression to search for.
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
