<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionOutputBlockParamShape = array{
 *   file_id: string, type: 'bash_code_execution_output'
 * }
 */
final class BetaBashCodeExecutionOutputBlockParam implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionOutputBlockParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_output' $type */
    #[Api]
    public string $type = 'bash_code_execution_output';

    #[Api]
    public string $file_id;

    /**
     * `new BetaBashCodeExecutionOutputBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionOutputBlockParam::with(file_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionOutputBlockParam)->withFileID(...)
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
