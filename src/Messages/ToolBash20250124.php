<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolBash20250124Shape = array{
 *   name: 'bash',
 *   type: 'bash_20250124',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class ToolBash20250124 implements BaseModel
{
    /** @use SdkModel<ToolBash20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'bash' $name
     */
    #[Required]
    public string $name = 'bash';

    /** @var 'bash_20250124' $type */
    #[Required]
    public string $type = 'bash_20250124';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        CacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $self = new self;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
