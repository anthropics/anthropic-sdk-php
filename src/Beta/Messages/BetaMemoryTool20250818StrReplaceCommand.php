<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818StrReplaceCommandShape = array{
 *   command: 'str_replace', new_str: string, old_str: string, path: string
 * }
 */
final class BetaMemoryTool20250818StrReplaceCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818StrReplaceCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'str_replace' $command
     */
    #[Required]
    public string $command = 'str_replace';

    /**
     * Text to replace with.
     */
    #[Required]
    public string $new_str;

    /**
     * Text to search for and replace.
     */
    #[Required]
    public string $old_str;

    /**
     * Path to the file where text should be replaced.
     */
    #[Required]
    public string $path;

    /**
     * `new BetaMemoryTool20250818StrReplaceCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818StrReplaceCommand::with(
     *   new_str: ..., old_str: ..., path: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818StrReplaceCommand)
     *   ->withNewStr(...)
     *   ->withOldStr(...)
     *   ->withPath(...)
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
        string $new_str,
        string $old_str,
        string $path
    ): self {
        $obj = new self;

        $obj['new_str'] = $new_str;
        $obj['old_str'] = $old_str;
        $obj['path'] = $path;

        return $obj;
    }

    /**
     * Text to replace with.
     */
    public function withNewStr(string $newStr): self
    {
        $obj = clone $this;
        $obj['new_str'] = $newStr;

        return $obj;
    }

    /**
     * Text to search for and replace.
     */
    public function withOldStr(string $oldStr): self
    {
        $obj = clone $this;
        $obj['old_str'] = $oldStr;

        return $obj;
    }

    /**
     * Path to the file where text should be replaced.
     */
    public function withPath(string $path): self
    {
        $obj = clone $this;
        $obj['path'] = $path;

        return $obj;
    }
}
