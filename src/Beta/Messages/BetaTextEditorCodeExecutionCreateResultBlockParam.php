<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionCreateResultBlockParamShape = array{
 *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
 * }
 */
final class BetaTextEditorCodeExecutionCreateResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionCreateResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_create_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_create_result';

    #[Required]
    public bool $is_file_update;

    /**
     * `new BetaTextEditorCodeExecutionCreateResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionCreateResultBlockParam::with(is_file_update: ...)
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
    public static function with(bool $is_file_update): self
    {
        $obj = new self;

        $obj['is_file_update'] = $is_file_update;

        return $obj;
    }

    public function withIsFileUpdate(bool $isFileUpdate): self
    {
        $obj = clone $this;
        $obj['is_file_update'] = $isFileUpdate;

        return $obj;
    }
}
