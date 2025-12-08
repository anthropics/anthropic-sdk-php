<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionOutputBlockShape = array{
 *   file_id: string, type: 'code_execution_output'
 * }
 */
final class BetaCodeExecutionOutputBlock implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionOutputBlockShape> */
    use SdkModel;

    /** @var 'code_execution_output' $type */
    #[Required]
    public string $type = 'code_execution_output';

    #[Required]
    public string $file_id;

    /**
     * `new BetaCodeExecutionOutputBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionOutputBlock::with(file_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionOutputBlock)->withFileID(...)
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
    public static function with(string $file_id): self
    {
        $obj = new self;

        $obj['file_id'] = $file_id;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj['file_id'] = $fileID;

        return $obj;
    }
}
