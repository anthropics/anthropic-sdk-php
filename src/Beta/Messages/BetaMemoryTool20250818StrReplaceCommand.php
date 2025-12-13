<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818StrReplaceCommandShape = array{
 *   command?: 'str_replace', newStr: string, oldStr: string, path: string
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
    #[Required('new_str')]
    public string $newStr;

    /**
     * Text to search for and replace.
     */
    #[Required('old_str')]
    public string $oldStr;

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
     *   newStr: ..., oldStr: ..., path: ...
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
        string $newStr,
        string $oldStr,
        string $path
    ): self {
        $self = new self;

        $self['newStr'] = $newStr;
        $self['oldStr'] = $oldStr;
        $self['path'] = $path;

        return $self;
    }

    /**
     * Text to replace with.
     */
    public function withNewStr(string $newStr): self
    {
        $self = clone $this;
        $self['newStr'] = $newStr;

        return $self;
    }

    /**
     * Text to search for and replace.
     */
    public function withOldStr(string $oldStr): self
    {
        $self = clone $this;
        $self['oldStr'] = $oldStr;

        return $self;
    }

    /**
     * Path to the file where text should be replaced.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }
}
