<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaBase64PDFSource implements BaseModel
{
    use Model;

    #[Api('media_type')]
    public string $mediaType = 'application/pdf';

    #[Api]
    public string $type = 'base64';

    #[Api]
    public string $data;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $data)
    {
        $this->data = $data;
    }
}

BetaBase64PDFSource::__introspect();
