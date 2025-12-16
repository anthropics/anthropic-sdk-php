<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content
 *
 * @phpstan-type BetaToolResultBlockParamShape = array{
 *   toolUseID: string,
 *   type: 'tool_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   content?: ContentShape|null,
 *   isError?: bool|null,
 * }
 */
final class BetaToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_result' $type */
    #[Required]
    public string $type = 'tool_result';

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>|null $content
     */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    #[Optional('is_error')]
    public ?bool $isError;

    /**
     * `new BetaToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolResultBlockParam::with(toolUseID: ...)
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param ContentShape $content
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param ContentShape $content
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
