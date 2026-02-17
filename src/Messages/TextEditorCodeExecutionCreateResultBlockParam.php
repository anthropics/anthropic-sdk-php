<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextEditorCodeExecutionCreateResultBlockParamShape = array{
 *   isFileUpdate: bool, type: 'text_editor_code_execution_create_result'
 * }
 */
final class TextEditorCodeExecutionCreateResultBlockParam implements BaseModel
{
    /** @use SdkModel<TextEditorCodeExecutionCreateResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_create_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_create_result';

    #[Required('is_file_update')]
    public bool $isFileUpdate;

    /**
     * `new TextEditorCodeExecutionCreateResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextEditorCodeExecutionCreateResultBlockParam::with(isFileUpdate: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextEditorCodeExecutionCreateResultBlockParam)->withIsFileUpdate(...)
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

    /**
     * @param 'text_editor_code_execution_create_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
