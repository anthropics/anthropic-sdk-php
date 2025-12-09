<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Tool reference block that can be included in tool_result content.
 *
 * @phpstan-type BetaToolReferenceBlockParamShape = array{
 *   toolName: string,
 *   type?: 'tool_reference',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaToolReferenceBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolReferenceBlockParamShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required]
    public string $type = 'tool_reference';

    #[Required('tool_name')]
    public string $toolName;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaToolReferenceBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolReferenceBlockParam::with(toolName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolReferenceBlockParam)->withToolName(...)
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
     */
    public static function with(
        string $toolName,
        BetaCacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $self = new self;

        $self['toolName'] = $toolName;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    public function withToolName(string $toolName): self
    {
        $self = clone $this;
        $self['toolName'] = $toolName;

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
}
