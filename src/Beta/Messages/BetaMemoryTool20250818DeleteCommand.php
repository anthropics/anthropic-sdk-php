<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818DeleteCommandShape = array{
 *   command: 'delete', path: string
 * }
 */
final class BetaMemoryTool20250818DeleteCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818DeleteCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'delete' $command
     */
    #[Required]
    public string $command = 'delete';

    /**
     * Path to the file or directory to delete.
     */
    #[Required]
    public string $path;

    /**
     * `new BetaMemoryTool20250818DeleteCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818DeleteCommand::with(path: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818DeleteCommand)->withPath(...)
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
    public static function with(string $path): self
    {
        $obj = new self;

        $obj['path'] = $path;

        return $obj;
    }

    /**
     * Path to the file or directory to delete.
     */
    public function withPath(string $path): self
    {
        $obj = clone $this;
        $obj['path'] = $path;

        return $obj;
    }
}
