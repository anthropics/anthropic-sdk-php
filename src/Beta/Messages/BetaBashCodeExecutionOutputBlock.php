<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_bash_code_execution_output_block = array{
 *   fileID: string, type: string
 * }
 */
final class BetaBashCodeExecutionOutputBlock implements BaseModel
{
    /** @use SdkModel<beta_bash_code_execution_output_block> */
    use SdkModel;

    #[Api]
    public string $type = 'bash_code_execution_output';

    #[Api('file_id')]
    public string $fileID;

    /**
     * `new BetaBashCodeExecutionOutputBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionOutputBlock::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionOutputBlock)->withFileID(...)
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
    public static function with(string $fileID): self
    {
        $obj = new self;

        $obj->fileID = $fileID;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj->fileID = $fileID;

        return $obj;
    }
}
