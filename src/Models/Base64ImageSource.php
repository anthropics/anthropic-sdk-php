<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class Base64ImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    #[Api('media_type')]
    public string $mediaType;

    #[Api]
    public string $type;

    /**
     * @param string $data
     * @param string $mediaType
     * @param string $type
     */
    final public function __construct($data, $mediaType, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

Base64ImageSource::_loadMetadata();
