<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam,
 *   tool_use_id: string,
 *   type: 'bash_code_execution_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
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

    #[Required]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaBashCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultBlockParam::with(content: ..., tool_use_id: ...)
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
     * @param BetaBashCodeExecutionToolResultErrorParam|array{
     *   error_code: value-of<ErrorCode>, type: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlockParam|array{
     *   content: list<BetaBashCodeExecutionOutputBlockParam>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'bash_code_execution_result',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        BetaBashCodeExecutionToolResultErrorParam|array|BetaBashCodeExecutionResultBlockParam $content,
        string $tool_use_id,
        BetaCacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param BetaBashCodeExecutionToolResultErrorParam|array{
     *   error_code: value-of<ErrorCode>, type: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlockParam|array{
     *   content: list<BetaBashCodeExecutionOutputBlockParam>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'bash_code_execution_result',
     * } $content
     */
    public function withContent(
        BetaBashCodeExecutionToolResultErrorParam|array|BetaBashCodeExecutionResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
