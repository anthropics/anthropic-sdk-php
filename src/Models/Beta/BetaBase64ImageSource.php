<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaBase64ImageSource implements BaseModel
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

BetaBase64ImageSource::_loadMetadata();
