<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionCreateResultBlockShape = array{
 *   isFileUpdate: bool, type?: 'text_editor_code_execution_create_result'
 * }
 */
final class BetaTextEditorCodeExecutionCreateResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionCreateResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_create_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_create_result';

    #[Required('is_file_update')]
    public bool $isFileUpdate;

    /**
     * `new BetaTextEditorCodeExecutionCreateResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionCreateResultBlock::with(isFileUpdate: ...)
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
    public static function with(bool $isFileUpdate): self
    {
        $self = new self;

        $self['isFileUpdate'] = $isFileUpdate;

        return $self;
    }

    public function withIsFileUpdate(bool $isFileUpdate): self
    {
        $self = clone $this;
        $self['isFileUpdate'] = $isFileUpdate;

        return $self;
    }
}
