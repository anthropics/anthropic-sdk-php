<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlockParam\Content
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaBashCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam|ContentShape,
 *   toolUseID: string,
 *   type: 'bash_code_execution_tool_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaBashCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result' $type */
    #[Required]
    public string $type = 'bash_code_execution_tool_result';

    #[Required]
    public BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaBashCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionToolResultBlockParam)
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
     * @param ContentShape $content
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        BetaBashCodeExecutionToolResultErrorParam|array|BetaBashCodeExecutionResultBlockParam $content,
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
     * @param ContentShape $content
     */
    public function withContent(
        BetaBashCodeExecutionToolResultErrorParam|array|BetaBashCodeExecutionResultBlockParam $content,
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
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
