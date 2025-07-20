<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaImageBlockParam\Source;

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

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->source = $source;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
