<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_request_mcp_tool_result_block_param = array{
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   content?: string|null|list<BetaTextBlockParam>,
 *   isError?: bool|null,
 * }
 */
final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<beta_request_mcp_tool_result_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'mcp_tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /** @var string|list<BetaTextBlockParam>|null $content */
    #[Api(union: Content::class, optional: true)]
    public string|array|null $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * `new BetaRequestMCPToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestMCPToolResultBlockParam::with(toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestMCPToolResultBlockParam)->withToolUseID(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param string|list<BetaTextBlockParam> $content
     */
    public static function with(
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
        string|array|null $content = null,
        ?bool $isError = null,
    ): self {
        $obj = new self;

        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $content && $obj->content = $content;
        null !== $isError && $obj->isError = $isError;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlockParam> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withIsError(bool $isError): self
    {
        $obj = clone $this;
        $obj->isError = $isError;

        return $obj;
    }
}
