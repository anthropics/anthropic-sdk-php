<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Tool reference block that can be included in tool_result content.
 *
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolReferenceBlockParamShape = array{
 *   toolName: string,
 *   type: 'tool_reference',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class ToolReferenceBlockParam implements BaseModel
{
    /** @use SdkModel<ToolReferenceBlockParamShape> */
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
    public ?CacheControlEphemeral $cacheControl;

    /**
     * `new ToolReferenceBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolReferenceBlockParam::with(toolName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolReferenceBlockParam)->withToolName(...)
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
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        string $toolName,
        CacheControlEphemeral|array|null $cacheControl = null
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
     * @param 'tool_reference' $type
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
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
