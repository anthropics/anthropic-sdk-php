<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class PlainTextSource implements BaseModel
{
    use Model;

    #[Api('media_type')]
    public string $mediaType = 'text/plain';

    #[Api]
    public string $type = 'text';

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

PlainTextSource::__introspect();
