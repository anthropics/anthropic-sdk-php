<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818RenameCommandShape = array{
 *   command: 'rename', new_path: string, old_path: string
 * }
 */
final class BetaMemoryTool20250818RenameCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818RenameCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'rename' $command
     */
    #[Api]
    public string $command = 'rename';

    /**
     * New path for the file or directory.
     */
    #[Api]
    public string $new_path;

    /**
     * Current path of the file or directory.
     */
    #[Api]
    public string $old_path;

    /**
     * `new BetaMemoryTool20250818RenameCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818RenameCommand::with(new_path: ..., old_path: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818RenameCommand)->withNewPath(...)->withOldPath(...)
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
    public static function with(string $new_path, string $old_path): self
    {
        $obj = new self;

        $obj['new_path'] = $new_path;
        $obj['old_path'] = $old_path;

        return $obj;
    }

    /**
     * New path for the file or directory.
     */
    public function withNewPath(string $newPath): self
    {
        $obj = clone $this;
        $obj['new_path'] = $newPath;

        return $obj;
    }

    /**
     * Current path of the file or directory.
     */
    public function withOldPath(string $oldPath): self
    {
        $obj = clone $this;
        $obj['old_path'] = $oldPath;

        return $obj;
    }
}
