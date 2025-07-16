<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaBase64PDFSource\MediaType;
use Anthropic\Models\Beta\BetaBase64PDFSource\Type;

final class BetaBase64PDFSource implements BaseModel
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

BetaBase64PDFSource::_loadMetadata();
