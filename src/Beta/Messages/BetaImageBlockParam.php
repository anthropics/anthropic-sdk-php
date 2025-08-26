<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaImageBlockParam\Source;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_image_block_param = array{
 *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaImageBlockParam implements BaseModel
{
    /** @use SdkModel<beta_image_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaImageBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaImageBlockParam::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaImageBlockParam)->withSource(...)
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
     */
    public static function with(
        BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->source = $source;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withSource(
        BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source
    ): self {
        $obj = clone $this;
        $obj->source = $source;

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
}
