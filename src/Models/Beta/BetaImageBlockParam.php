<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaImageBlockParam\Type;

final class BetaImageBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->source = $source;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

BetaImageBlockParam::_loadMetadata();
