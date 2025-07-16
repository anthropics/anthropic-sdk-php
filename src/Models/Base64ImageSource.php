<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Base64ImageSource\MediaType;

final class Base64ImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'base64';

    #[Api]
    public string $data;

    /** @var MediaType::* $mediaType */
    #[Api('media_type')]
    public string $mediaType;

    /**
     * You must use named parameters to construct this object.
     *
     * @param MediaType::* $mediaType
     */
    final public function __construct(string $data, string $mediaType)
    {
        $this->data = $data;
        $this->mediaType = $mediaType;
    }
}

Base64ImageSource::__introspect();
