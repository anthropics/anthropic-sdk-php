<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818InsertCommandShape = array{
 *   command: 'insert', insert_line: int, insert_text: string, path: string
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
    #[Api]
    public string $command = 'insert';

    /**
     * Line number where text should be inserted.
     */
    #[Api]
    public int $insert_line;

    /**
     * Text to insert at the specified line.
     */
    #[Api]
    public string $insert_text;

    /**
     * Path to the file where text should be inserted.
     */
    #[Api]
    public string $path;

    /**
     * `new BetaMemoryTool20250818InsertCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818InsertCommand::with(
     *   insert_line: ..., insert_text: ..., path: ...
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
        int $insert_line,
        string $insert_text,
        string $path
    ): self {
        $obj = new self;

        $obj['insert_line'] = $insert_line;
        $obj['insert_text'] = $insert_text;
        $obj['path'] = $path;

        return $obj;
    }

    /**
     * Line number where text should be inserted.
     */
    public function withInsertLine(int $insertLine): self
    {
        $obj = clone $this;
        $obj['insert_line'] = $insertLine;

        return $obj;
    }

    /**
     * Text to insert at the specified line.
     */
    public function withInsertText(string $insertText): self
    {
        $obj = clone $this;
        $obj['insert_text'] = $insertText;

        return $obj;
    }

    /**
     * Path to the file where text should be inserted.
     */
    public function withPath(string $path): self
    {
        $obj = clone $this;
        $obj['path'] = $path;

        return $obj;
    }
}
