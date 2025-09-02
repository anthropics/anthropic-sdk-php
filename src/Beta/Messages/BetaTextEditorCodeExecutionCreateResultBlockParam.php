<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_editor_code_execution_create_result_block_param = array{
 *   isFileUpdate: bool, type: string
 * }
 */
final class BetaTextEditorCodeExecutionCreateResultBlockParam implements BaseModel
{
    /** @use SdkModel<beta_text_editor_code_execution_create_result_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_create_result';

    #[Api('is_file_update')]
    public bool $isFileUpdate;

    /**
     * `new BetaTextEditorCodeExecutionCreateResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionCreateResultBlockParam::with(isFileUpdate: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionCreateResultBlockParam)->withIsFileUpdate(...)
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
    public static function with(bool $isFileUpdate): self
    {
        $obj = new self;

        $obj->isFileUpdate = $isFileUpdate;

        return $obj;
    }

    public function withIsFileUpdate(bool $isFileUpdate): self
    {
        $obj = clone $this;
        $obj->isFileUpdate = $isFileUpdate;

        return $obj;
    }
}
