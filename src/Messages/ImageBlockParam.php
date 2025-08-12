<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ImageBlockParam\Source;

/**
 * @phpstan-type image_block_param_alias = array{
 *   source: Base64ImageSource|URLImageSource,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 * }
 */
final class ImageBlockParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public Base64ImageSource|URLImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        Base64ImageSource|URLImageSource $source,
        ?CacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->source = $source;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function setSource(Base64ImageSource|URLImageSource $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
