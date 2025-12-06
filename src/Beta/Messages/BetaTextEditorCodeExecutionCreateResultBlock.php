<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionCreateResultBlockShape = array{
 *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
 * }
 */
final class BetaTextEditorCodeExecutionCreateResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionCreateResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_create_result' $type */
    #[Api]
    public string $type = 'text_editor_code_execution_create_result';

    #[Api]
    public bool $is_file_update;

    /**
     * `new BetaTextEditorCodeExecutionCreateResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionCreateResultBlock::with(is_file_update: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionCreateResultBlock)->withIsFileUpdate(...)
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
