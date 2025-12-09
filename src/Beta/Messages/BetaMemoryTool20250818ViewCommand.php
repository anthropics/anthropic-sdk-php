<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818ViewCommandShape = array{
 *   command?: 'view', path: string, viewRange?: list<int>|null
 * }
 */
final class BetaMemoryTool20250818ViewCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818ViewCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'view' $command
     */
    #[Required]
    public string $command = 'view';

    /**
     * Path to directory or file to view.
     */
    #[Required]
    public string $path;

    /**
     * Optional line range for viewing specific lines.
     *
     * @var list<int>|null $viewRange
     */
    #[Optional('view_range', list: 'int')]
    public ?array $viewRange;

    /**
     * `new BetaMemoryTool20250818ViewCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818ViewCommand::with(path: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818ViewCommand)->withPath(...)
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
     * @param list<int> $viewRange
     */
    public static function with(string $path, ?array $viewRange = null): self
    {
        $obj = new self;

        $obj['path'] = $path;

        null !== $viewRange && $obj['viewRange'] = $viewRange;

        return $obj;
    }

    /**
     * Path to directory or file to view.
     */
    public function withPath(string $path): self
    {
        $obj = clone $this;
        $obj['path'] = $path;

        return $obj;
    }

    /**
     * Optional line range for viewing specific lines.
     *
     * @param list<int> $viewRange
     */
    public function withViewRange(array $viewRange): self
    {
        $obj = clone $this;
        $obj['viewRange'] = $viewRange;

        return $obj;
    }
}
