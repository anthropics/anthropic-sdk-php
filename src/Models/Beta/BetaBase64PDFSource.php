<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaBase64PDFSource implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    #[Api('media_type')]
    public string $mediaType;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
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
