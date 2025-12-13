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
 *   toolUseID: string,
 *   type?: 'mcp_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   content?: string|null|list<BetaTextBlockParam>,
 *   isError?: bool|null,
 * }
 */
final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'mcp_tool_result' $type */
    #[Required]
    public string $type = 'mcp_tool_result';

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /** @var string|list<BetaTextBlockParam>|null $content */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    #[Optional('is_error')]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     */
    public static function with(
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        string|array|null $content = null,
        ?bool $isError = null,
    ): self {
        $self = new self;

        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;

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
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withIsError(bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

        return $self;
    }
}
