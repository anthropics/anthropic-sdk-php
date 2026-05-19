<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Input payload for the `read` tool. Reads file contents
 * relative to the runner's working directory (or absolute when
 * the runner permits).
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401ReadInputShape = array{
 *   filePath: string, viewRange?: list<int>|null
 * }
 */
final class BetaManagedAgentsAgentToolset20260401ReadInput implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401ReadInputShape> */
    use SdkModel;

    /**
     * Path of the file to read.
     */
    #[Required('file_path')]
    public string $filePath;

    /**
     * Optional `[start_line, end_line]` 1-indexed inclusive
     * range. When omitted the entire file is returned.
     * `end_line` of 0 or negative means "to end of file".
     *
     * @var list<int>|null $viewRange
     */
    #[Optional('view_range', list: 'int')]
    public ?array $viewRange;

    /**
     * `new BetaManagedAgentsAgentToolset20260401ReadInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401ReadInput::with(filePath: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401ReadInput)->withFilePath(...)
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
     *
     * @param list<int>|null $viewRange
     */
    public static function with(string $filePath, ?array $viewRange = null): self
    {
        $self = new self;

        $self['filePath'] = $filePath;

        null !== $viewRange && $self['viewRange'] = $viewRange;

        return $self;
    }

    /**
     * Path of the file to read.
     */
    public function withFilePath(string $filePath): self
    {
        $self = clone $this;
        $self['filePath'] = $filePath;

        return $self;
    }

    /**
     * Optional `[start_line, end_line]` 1-indexed inclusive
     * range. When omitted the entire file is returned.
     * `end_line` of 0 or negative means "to end of file".
     *
     * @param list<int> $viewRange
     */
    public function withViewRange(array $viewRange): self
    {
        $self = clone $this;
        $self['viewRange'] = $viewRange;

        return $self;
    }
}
