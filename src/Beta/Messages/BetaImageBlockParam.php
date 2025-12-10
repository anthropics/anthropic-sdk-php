<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBase64ImageSource\MediaType;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaImageBlockParam\Source;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaImageBlockParamShape = array{
 *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
 *   type?: 'image',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaImageBlockParam implements BaseModel
{
    /** @use SdkModel<BetaImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Required]
    public string $type = 'image';

    #[Required(union: Source::class)]
    public BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaBase64ImageSource|array{
     *   data: string, mediaType: value-of<MediaType>, type?: 'base64'
     * }|BetaURLImageSource|array{type?: 'url', url: string}|BetaFileImageSource|array{
     *   fileID: string, type?: 'file'
     * } $source
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource $source,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $obj = new self;

        $obj['source'] = $source;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * @param BetaBase64ImageSource|array{
     *   data: string, mediaType: value-of<MediaType>, type?: 'base64'
     * }|BetaURLImageSource|array{type?: 'url', url: string}|BetaFileImageSource|array{
     *   fileID: string, type?: 'file'
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
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
