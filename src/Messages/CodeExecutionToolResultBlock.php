<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CodeExecutionToolResultBlockContentVariants from \Anthropic\Messages\CodeExecutionToolResultBlockContent
 * @phpstan-import-type CodeExecutionToolResultBlockContentShape from \Anthropic\Messages\CodeExecutionToolResultBlockContent
 *
 * @phpstan-type CodeExecutionToolResultBlockShape = array{
 *   content: CodeExecutionToolResultBlockContentShape,
 *   toolUseID: string,
 *   type: 'code_execution_tool_result',
 * }
 */
final class CodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<CodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @var CodeExecutionToolResultBlockContentVariants $content
     */
    #[Required]
    public CodeExecutionToolResultError|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new CodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CodeExecutionToolResultBlock)->withContent(...)->withToolUseID(...)
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
     *
     * @param CodeExecutionToolResultBlockContentShape $content
     */
    public static function with(
        CodeExecutionToolResultError|array|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock $content,
        string $toolUseID,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @param CodeExecutionToolResultBlockContentShape $content
     */
    public function withContent(
        CodeExecutionToolResultError|array|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock $content,
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'code_execution_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
