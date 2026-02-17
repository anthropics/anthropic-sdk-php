<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CodeExecutionToolResultBlockParamContentVariants from \Anthropic\Messages\CodeExecutionToolResultBlockParamContent
 * @phpstan-import-type CodeExecutionToolResultBlockParamContentShape from \Anthropic\Messages\CodeExecutionToolResultBlockParamContent
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type CodeExecutionToolResultBlockParamShape = array{
 *   content: CodeExecutionToolResultBlockParamContentShape,
 *   toolUseID: string,
 *   type: 'code_execution_tool_result',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class CodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<CodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @var CodeExecutionToolResultBlockParamContentVariants $content
     */
    #[Required]
    public CodeExecutionToolResultErrorParam|CodeExecutionResultBlockParam|EncryptedCodeExecutionResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * `new CodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CodeExecutionToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CodeExecutionToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param CodeExecutionToolResultBlockParamContentShape $content
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        CodeExecutionToolResultErrorParam|array|CodeExecutionResultBlockParam|EncryptedCodeExecutionResultBlockParam $content,
        string $toolUseID,
        CacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @param CodeExecutionToolResultBlockParamContentShape $content
     */
    public function withContent(
        CodeExecutionToolResultErrorParam|array|CodeExecutionResultBlockParam|EncryptedCodeExecutionResultBlockParam $content,
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

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
