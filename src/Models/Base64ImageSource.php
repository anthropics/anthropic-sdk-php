<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Base64ImageSource\MediaType;
use Anthropic\Models\Base64ImageSource\Type;

final class Base64ImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    /** @var MediaType::* $mediaType */
    #[Api('media_type')]
    public string $mediaType;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param MediaType::* $mediaType
     * @param Type::*      $type
     */
    final public function __construct(
        string $data,
        string $mediaType,
        string $type
    ) {
        $this->data = $data;
        $this->mediaType = $mediaType;
        $this->type = $type;
    }
}

Base64ImageSource::_loadMetadata();
