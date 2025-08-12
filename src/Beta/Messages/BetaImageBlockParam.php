<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaImageBlockParam\Source;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_image_block_param_alias = array{
 *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 * }
 */
final class BetaImageBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

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
        BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->source = $source;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function setSource(
        BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source
    ): self {
        $this->source = $source;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
