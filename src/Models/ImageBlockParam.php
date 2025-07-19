<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ImageBlockParam\Source;

final class ImageBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'image';

    #[Api(union: Source::class)]
    public Base64ImageSource|URLImageSource $source;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        Base64ImageSource|URLImageSource $source,
        ?CacheControlEphemeral $cacheControl = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->source = $source;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
