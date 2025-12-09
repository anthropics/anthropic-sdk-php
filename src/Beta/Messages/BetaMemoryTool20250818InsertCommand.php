<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818InsertCommandShape = array{
 *   command?: 'insert', insertLine: int, insertText: string, path: string
 * }
 */
final class BetaMemoryTool20250818InsertCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818InsertCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'insert' $command
     */
    #[Required]
    public string $command = 'insert';

    /**
     * Line number where text should be inserted.
     */
    #[Required('insert_line')]
    public int $insertLine;

    /**
     * Text to insert at the specified line.
     */
    #[Required('insert_text')]
    public string $insertText;

    /**
     * Path to the file where text should be inserted.
     */
    #[Required]
    public string $path;

    /**
     * `new BetaMemoryTool20250818InsertCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818InsertCommand::with(
     *   insertLine: ..., insertText: ..., path: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818InsertCommand)
     *   ->withInsertLine(...)
     *   ->withInsertText(...)
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
        int $insertLine,
        string $insertText,
        string $path
    ): self {
        $self = new self;

        $self['insertLine'] = $insertLine;
        $self['insertText'] = $insertText;
        $self['path'] = $path;

        return $self;
    }

    /**
     * Line number where text should be inserted.
     */
    public function withInsertLine(int $insertLine): self
    {
        $self = clone $this;
        $self['insertLine'] = $insertLine;

        return $self;
    }

    /**
     * Text to insert at the specified line.
     */
    public function withInsertText(string $insertText): self
    {
        $self = clone $this;
        $self['insertText'] = $insertText;

        return $self;
    }

    /**
     * Path to the file where text should be inserted.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }
}
