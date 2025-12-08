<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestMCPToolResultBlockParamShape = array{
 *   tool_use_id: string,
 *   type: 'mcp_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   content?: string|null|list<BetaTextBlockParam>,
 *   is_error?: bool|null,
 * }
 */
final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'mcp_tool_result' $type */
    #[Required]
    public string $type = 'mcp_tool_result';

    #[Required]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /** @var string|list<BetaTextBlockParam>|null $content */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    #[Optional]
    public ?bool $is_error;

    /**
     * `new BetaRequestMCPToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestMCPToolResultBlockParam::with(tool_use_id: ...)
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     */
    public static function with(
        string $tool_use_id,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        string|array|null $content = null,
        ?bool $is_error = null,
    ): self {
        $obj = new self;

        $obj['tool_use_id'] = $tool_use_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $content && $obj['content'] = $content;
        null !== $is_error && $obj['is_error'] = $is_error;

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

    /**
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withIsError(bool $isError): self
    {
        $obj = clone $this;
        $obj['is_error'] = $isError;

        return $obj;
    }
}
