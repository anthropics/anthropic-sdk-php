<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam,
 *   tool_use_id: string,
 *   type: 'code_execution_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    #[Required]
    public BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam $content;

    #[Required]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlockParam::with(content: ..., tool_use_id: ...)
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
     * @param BetaCodeExecutionToolResultErrorParam|array{
     *   error_code: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlockParam|array{
     *   content: list<BetaCodeExecutionOutputBlockParam>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'code_execution_result',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        BetaCodeExecutionToolResultErrorParam|array|BetaCodeExecutionResultBlockParam $content,
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
     * @param BetaCodeExecutionToolResultErrorParam|array{
     *   error_code: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlockParam|array{
     *   content: list<BetaCodeExecutionOutputBlockParam>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'code_execution_result',
     * } $content
     */
    public function withContent(
        BetaCodeExecutionToolResultErrorParam|array|BetaCodeExecutionResultBlockParam $content,
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
