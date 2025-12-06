<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Base64ImageSource\MediaType;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\ImageBlockParam\Source;

/**
 * @phpstan-type ImageBlockParamShape = array{
 *   source: Base64ImageSource|URLImageSource,
 *   type: 'image',
 *   cache_control?: CacheControlEphemeral|null,
 * }
 */
final class ImageBlockParam implements BaseModel
{
    /** @use SdkModel<ImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public Base64ImageSource|URLImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

    /**
     * `new ImageBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageBlockParam::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageBlockParam)->withSource(...)
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
     * @param Base64ImageSource|array{
     *   data: string, media_type: value-of<MediaType>, type: 'base64'
     * }|URLImageSource|array{type: 'url', url: string} $source
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        Base64ImageSource|array|URLImageSource $source,
        CacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['source'] = $source;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param Base64ImageSource|array{
     *   data: string, media_type: value-of<MediaType>, type: 'base64'
     * }|URLImageSource|array{type: 'url', url: string} $source
     */
    public function withSource(
        Base64ImageSource|array|URLImageSource $source
    ): self {
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
