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
 *   toolUseID: string,
 *   type?: 'code_execution_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
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
     * @param BetaCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type?: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlockParam|array{
     *   content: list<BetaCodeExecutionOutputBlockParam>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'code_execution_result',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaCodeExecutionToolResultErrorParam|array|BetaCodeExecutionResultBlockParam $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['toolUseID'] = $toolUseID;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * @param BetaCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type?: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlockParam|array{
     *   content: list<BetaCodeExecutionOutputBlockParam>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'code_execution_result',
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
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
