<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ImageBlockParam\Type;

final class ImageBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public Base64ImageSource|URLImageSource $source;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        Base64ImageSource|URLImageSource $source,
        string $type,
        ?CacheControlEphemeral $cacheControl = null,
    ) {
        $this->source = $source;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

ImageBlockParam::_loadMetadata();
