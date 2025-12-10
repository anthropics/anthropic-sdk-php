<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMemoryTool20250818CreateCommandShape = array{
 *   command?: 'create', fileText: string, path: string
 * }
 */
final class BetaMemoryTool20250818CreateCommand implements BaseModel
{
    /** @use SdkModel<BetaMemoryTool20250818CreateCommandShape> */
    use SdkModel;

    /**
     * Command type identifier.
     *
     * @var 'create' $command
     */
    #[Required]
    public string $command = 'create';

    /**
     * Content to write to the file.
     */
    #[Required('file_text')]
    public string $fileText;

    /**
     * Path where the file should be created.
     */
    #[Required]
    public string $path;

    /**
     * `new BetaMemoryTool20250818CreateCommand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMemoryTool20250818CreateCommand::with(fileText: ..., path: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMemoryTool20250818CreateCommand)->withFileText(...)->withPath(...)
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
    public static function with(string $fileText, string $path): self
    {
        $obj = new self;

        $obj['fileText'] = $fileText;
        $obj['path'] = $path;

        return $obj;
    }

    /**
     * Content to write to the file.
     */
    public function withFileText(string $fileText): self
    {
        $obj = clone $this;
        $obj['fileText'] = $fileText;

        return $obj;
    }

    /**
     * Path where the file should be created.
     */
    public function withPath(string $path): self
    {
        $obj = clone $this;
        $obj['path'] = $path;

        return $obj;
    }
}
