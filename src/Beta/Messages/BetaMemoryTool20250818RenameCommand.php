<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818RenameCommandShape = array{
 *   command?: 'rename', newPath: string, oldPath: string
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
    #[Required]
    public string $command = 'rename';

    /**
     * New path for the file or directory.
     */
    #[Required('new_path')]
    public string $newPath;

    /**
     * Current path of the file or directory.
     */
    #[Required('old_path')]
    public string $oldPath;

    /**
     * `new BetaMemoryTool20250818RenameCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818RenameCommand::with(newPath: ..., oldPath: ...)
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
    public static function with(string $newPath, string $oldPath): self
    {
        $obj = new self;

        $obj['newPath'] = $newPath;
        $obj['oldPath'] = $oldPath;

        return $obj;
    }

    /**
     * New path for the file or directory.
     */
    public function withNewPath(string $newPath): self
    {
        $obj = clone $this;
        $obj['newPath'] = $newPath;

        return $obj;
    }

    /**
     * Current path of the file or directory.
     */
    public function withOldPath(string $oldPath): self
    {
        $obj = clone $this;
        $obj['oldPath'] = $oldPath;

        return $obj;
    }
}
