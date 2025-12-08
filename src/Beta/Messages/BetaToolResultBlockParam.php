<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolResultBlockParamShape = array{
 *   tool_use_id: string,
 *   type: 'tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   content?: string|null|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>,
 *   is_error?: bool|null,
 * }
 */
final class BetaToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_result' $type */
    #[Required]
    public string $type = 'tool_result';

    #[Required]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * @var string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>|null $content
     */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    #[Optional]
    public ?bool $is_error;

    /**
     * `new BetaToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolResultBlockParam::with(tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolResultBlockParam)->withToolUseID(...)
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
     * }|BetaImageBlockParam|array{
     *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
     *   type: 'image',
     *   cache_control?: BetaCacheControlEphemeral|null,
     * }|BetaSearchResultBlockParam|array{
     *   content: list<BetaTextBlockParam>,
     *   source: string,
     *   title: string,
     *   type: 'search_result',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     * }|BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type: 'document',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|BetaToolReferenceBlockParam|array{
     *   tool_name: string,
     *   type: 'tool_reference',
     *   cache_control?: BetaCacheControlEphemeral|null,
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
     * }|BetaImageBlockParam|array{
     *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
     *   type: 'image',
     *   cache_control?: BetaCacheControlEphemeral|null,
     * }|BetaSearchResultBlockParam|array{
     *   content: list<BetaTextBlockParam>,
     *   source: string,
     *   title: string,
     *   type: 'search_result',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     * }|BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type: 'document',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|BetaToolReferenceBlockParam|array{
     *   tool_name: string,
     *   type: 'tool_reference',
     *   cache_control?: BetaCacheControlEphemeral|null,
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
