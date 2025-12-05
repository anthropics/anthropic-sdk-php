<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBase64ImageSource\MediaType;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaImageBlockParam\Source;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaImageBlockParamShape = array{
 *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
 *   type: 'image',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaImageBlockParam implements BaseModel
{
    /** @use SdkModel<BetaImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaBase64ImageSource|array{
     *   data: string, media_type: value-of<MediaType>, type: 'base64'
     * }|BetaURLImageSource|array{type: 'url', url: string}|BetaFileImageSource|array{
     *   file_id: string, type: 'file'
     * } $source
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource $source,
        BetaCacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['source'] = $source;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param BetaBase64ImageSource|array{
     *   data: string, media_type: value-of<MediaType>, type: 'base64'
     * }|BetaURLImageSource|array{type: 'url', url: string}|BetaFileImageSource|array{
     *   file_id: string, type: 'file'
     * } $source
     */
    public function withSource(
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource $source
    ): self {
        $obj = clone $this;
        $obj['source'] = $source;

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
}
