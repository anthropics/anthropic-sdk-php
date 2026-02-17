<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCodeExecutionToolResultBlockParamContentVariants from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParamContent
 * @phpstan-import-type BetaCodeExecutionToolResultBlockParamContentShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParamContent
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaCodeExecutionToolResultBlockParamContentShape,
 *   toolUseID: string,
 *   type: 'code_execution_tool_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    /**
     * Code execution result with encrypted stdout for PFC + web_search results.
     *
     * @var BetaCodeExecutionToolResultBlockParamContentVariants $content
     */
    #[Required]
    public BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam|BetaEncryptedCodeExecutionResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultBlockParam)
     *   ->withContent(...)
     *   ->withToolUseID(...)
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
     * @param BetaCodeExecutionToolResultBlockParamContentShape $content
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        BetaCodeExecutionToolResultErrorParam|array|BetaCodeExecutionResultBlockParam|BetaEncryptedCodeExecutionResultBlockParam $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
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
     * @param BetaCodeExecutionToolResultBlockParamContentShape $content
     */
    public function withContent(
        BetaCodeExecutionToolResultErrorParam|array|BetaCodeExecutionResultBlockParam|BetaEncryptedCodeExecutionResultBlockParam $content,
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
