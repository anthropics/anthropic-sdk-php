<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCodeExecutionToolResultBlockContentVariants from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockContent
 * @phpstan-import-type BetaCodeExecutionToolResultBlockContentShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockContent
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockShape = array{
 *   content: BetaCodeExecutionToolResultBlockContentShape,
 *   toolUseID: string,
 *   type: 'code_execution_tool_result',
 * }
 */
final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @var BetaCodeExecutionToolResultBlockContentVariants $content
     */
    #[Required]
    public BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock|BetaEncryptedCodeExecutionResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param BetaCodeExecutionToolResultBlockContentShape $content
     */
    public static function with(
        BetaCodeExecutionToolResultError|array|BetaCodeExecutionResultBlock|BetaEncryptedCodeExecutionResultBlock $content,
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
     * @param BetaCodeExecutionToolResultBlockContentShape $content
     */
    public function withContent(
        BetaCodeExecutionToolResultError|array|BetaCodeExecutionResultBlock|BetaEncryptedCodeExecutionResultBlock $content,
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
