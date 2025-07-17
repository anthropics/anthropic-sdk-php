<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaURLPDFSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'url';

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $url)
    {
        self::introspect();

        $this->url = $url;
    }
}
