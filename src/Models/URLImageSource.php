<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\URLImageSource\Type;

final class URLImageSource implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $type, string $url)
    {
        $this->type = $type;
        $this->url = $url;
    }
}

URLImageSource::_loadMetadata();
