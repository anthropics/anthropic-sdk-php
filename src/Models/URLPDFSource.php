<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class URLPDFSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * @param string $type
     * @param string $url
     */
    final public function __construct($type, $url)
    {
        $this->constructFromArgs(func_get_args());
    }
}

URLPDFSource::_loadMetadata();
