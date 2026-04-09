<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlockParam\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlockParam\Content
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaAdvisorToolResultBlockParamShape = array{
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'advisor_tool_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaAdvisorToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaAdvisorToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'advisor_tool_result' $type */
    #[Required]
    public string $type = 'advisor_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public BetaAdvisorToolResultErrorParam|BetaAdvisorResultBlockParam|BetaAdvisorRedactedResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaAdvisorToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        BetaAdvisorToolResultErrorParam|array|BetaAdvisorResultBlockParam|BetaAdvisorRedactedResultBlockParam $content,
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
        BetaAdvisorToolResultErrorParam|array|BetaAdvisorResultBlockParam|BetaAdvisorRedactedResultBlockParam $content,
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
     * @param 'advisor_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
