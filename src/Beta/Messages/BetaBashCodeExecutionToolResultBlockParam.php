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
 *   toolUseID: string,
 *   type?: 'bash_code_execution_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
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
     * @param BetaBashCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>, type?: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlockParam|array{
     *   content: list<BetaBashCodeExecutionOutputBlockParam>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'bash_code_execution_result',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaBashCodeExecutionToolResultErrorParam|array|BetaBashCodeExecutionResultBlockParam $content,
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
     * @param BetaBashCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>, type?: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlockParam|array{
     *   content: list<BetaBashCodeExecutionOutputBlockParam>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'bash_code_execution_result',
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
